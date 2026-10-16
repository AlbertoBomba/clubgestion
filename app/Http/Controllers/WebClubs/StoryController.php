<?php

namespace App\Http\Controllers\WebClubs;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClubStoryRequest;
use App\Models\ClubStory;
use App\Models\StoryCategory;
use App\Models\StoryMedia;
use App\Services\ClubStorySubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoryController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = $this->schoolId();
        $visitor = $request->cookie('story_visitor', '');
        $filters = $request->validate(['category' => ['nullable', 'integer', 'min:1']]);
        $stories = ClubStory::where('sports_school_id', $schoolId)->published()
            ->when($filters['category'] ?? null, fn ($query, $category) => $query->where('story_category_id', $category))
            ->with(['category', 'media'])
            ->withExists(['likes as liked_by_visitor' => fn ($query) => $query->where('visitor_hash',
                Str::isUuid($visitor) ? $this->visitorHash($visitor) : '')])
            ->withCount(['likes',
                'comments as approved_comments_count' => fn ($query) => $query->where('status', 'approved')])
            ->orderByDesc('published_at')->orderByDesc('id')->paginate(12)->withQueryString();
        $response = response()->view('webclubs.stories.index', [
            'stories' => $stories,
            'categories' => $this->categories($schoolId),
            'storyContext' => array_filter([
                'category' => $filters['category'] ?? null,
                'feed_page' => $stories->currentPage(),
            ]),
        ]);

        if (! Str::isUuid($request->cookie('story_visitor', ''))) {
            $response->cookie('story_visitor', (string) Str::uuid(), 60 * 24 * 365, '/', null, $request->isSecure(), true, false, 'lax');
        }

        return $response;
    }

    public function create()
    {
        return view('webclubs.stories.create', ['categories' => $this->categories($this->schoolId())]);
    }

    public function store(StoreClubStoryRequest $request, ClubStorySubmission $submission)
    {
        $submission->store($this->schoolId(), $request->validated(), $request->file('media', []));

        return redirect()->route('webclubs.stories.index')->with('message', 'Gracias por compartir tu historia. El club la revisará antes de publicarla.');
    }

    public function show(Request $request, int $story)
    {
        $storyContext = $this->storyContext($request);
        $story = $this->publishedStory($story)->load(['category', 'media'])
            ->loadCount('likes');
        $comments = $story->comments()->where('status', 'approved')->latest()->paginate(15)->appends($storyContext);
        $visitor = $request->cookie('story_visitor', '');
        $story->setAttribute('liked_by_visitor', Str::isUuid($visitor)
            && $story->likes()->where('visitor_hash', $this->visitorHash($visitor))->exists());
        $response = response()->view('webclubs.stories.show', compact('story', 'comments', 'storyContext'));
        if (! Str::isUuid($visitor)) {
            $response->cookie('story_visitor', (string) Str::uuid(), 60 * 24 * 365, '/', null, $request->isSecure(), true, false, 'lax');
        }

        return $response;
    }

    public function comment(Request $request, int $story)
    {
        $storyContext = $this->storyContext($request);
        $story = $this->publishedStory($story);
        $name = is_string($request->input('author_name')) ? trim($request->input('author_name')) : null;
        $email = is_string($request->input('author_email')) ? trim($request->input('author_email')) : null;
        $payload = $request->all();
        $payload['author_name'] = $name === '' ? null : $name;
        $payload['author_email'] = $email === '' ? null : $email;
        $data = validator($payload, [
            'author_name' => ['nullable', 'string', 'max:100'],
            'author_email' => ['nullable', 'email', 'max:255'],
            'body' => ['required', 'string', 'max:2000'],
            'consent' => ['accepted'],
            'website' => ['nullable', 'max:0'],
        ])->validate();
        $story->comments()->create([
            'author_name' => filled($data['author_name'] ?? null) ? trim($data['author_name']) : 'Anónimo',
            'author_email' => $data['author_email'] ?? null,
            'body' => $data['body'], 'consented_at' => now(), 'status' => 'pending',
        ]);

        return redirect()->route('webclubs.stories.show', ['story' => $story->id] + $storyContext)->with('message', 'Tu comentario está pendiente de aprobación.');
    }

    public function like(Request $request, int $story)
    {
        $storyContext = $this->storyContext($request);
        $story = $this->publishedStory($story);
        $data = $request->validate([
            'from' => ['nullable', 'in:index,show'],
            'category' => ['nullable', 'integer', 'min:1'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);
        $visitor = $request->cookie('story_visitor', '');
        abort_unless(Str::isUuid($visitor), 422, 'Activa las cookies y vuelve a abrir la historia para marcar Me gusta.');
        $like = $story->likes()->firstOrCreate(['visitor_hash' => $this->visitorHash($visitor)], ['status' => 'approved']);
        $message = $like->wasRecentlyCreated ? '¡Gracias! Tu Me gusta ya se ha contabilizado.' : 'Ya has dado Me gusta a esta historia.';

        if (($data['from'] ?? 'show') === 'index') {
            return redirect()->route('webclubs.stories.index', array_filter([
                'category' => $data['category'] ?? null, 'page' => $data['page'] ?? null,
            ]))->with('message', $message);
        }

        return redirect()->route('webclubs.stories.show', ['story' => $story->id] + $storyContext)->with('message', $message);
    }

    public function media(int $media)
    {
        $media = StoryMedia::findOrFail($media);
        $story = ClubStory::withoutGlobalScopes()->findOrFail($media->club_story_id);
        $public = $story->sports_school_id === tenantService()->getCurrentSchoolId()
            && $story->status === 'approved' && $story->published_at !== null;
        $moderator = Gate::allows('moderate-club-stories')
            && $story->sports_school_id === auth()->user()->sports_school_id;
        abort_unless($public || $moderator, 404);
        $disk = Storage::disk('story-media');
        abort_unless($disk->exists($media->path), 404);

        // Binary responses support byte ranges for seeking through uploaded videos.
        return response()->file($disk->path($media->path), [
            'Content-Type' => $media->mime_type,
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'private, no-store',
        ])->setPrivate();
    }

    private function schoolId(): int
    {
        abort_unless(currentSchool(), 404);

        return currentSchool()->id;
    }

    private function storyContext(Request $request): array
    {
        return array_filter($request->validate([
            'category' => ['nullable', 'integer', 'min:1'],
            'feed_page' => ['nullable', 'integer', 'min:1'],
        ]));
    }

    private function publishedStory(int $id): ClubStory
    {
        return ClubStory::where('sports_school_id', $this->schoolId())->published()->findOrFail($id);
    }

    private function categories(int $schoolId)
    {
        return StoryCategory::where('sports_school_id', $schoolId)
            ->whereHas('stories', fn ($query) => $query->published())->orderBy('name')->get();
    }

    private function visitorHash(string $visitor): string
    {
        return hash_hmac('sha256', $visitor, config('app.key'));
    }
}
