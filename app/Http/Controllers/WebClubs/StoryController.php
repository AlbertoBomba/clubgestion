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
        $filters = $request->validate(['category' => ['nullable', 'integer', 'min:1']]);
        $stories = ClubStory::where('sports_school_id', $schoolId)->published()
            ->when($filters['category'] ?? null, fn ($query, $category) => $query->where('story_category_id', $category))
            ->with(['category', 'media'])
            ->withCount(['likes as approved_likes_count' => fn ($query) => $query->where('status', 'approved'),
                'comments as approved_comments_count' => fn ($query) => $query->where('status', 'approved')])
            ->orderByDesc('published_at')->orderByDesc('id')->paginate(12)->withQueryString();
        $response = response()->view('webclubs.stories.index', [
            'stories' => $stories,
            'categories' => $this->categories($schoolId),
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
        $story = $this->publishedStory($story)->load(['category', 'media'])
            ->loadCount(['likes as approved_likes_count' => fn ($query) => $query->where('status', 'approved')]);
        $comments = $story->comments()->where('status', 'approved')->latest()->paginate(15);
        $visitor = $request->cookie('story_visitor', '');
        $likeStatus = Str::isUuid($visitor)
            ? $story->likes()->where('visitor_hash', $this->visitorHash($visitor))->value('status')
            : null;
        $response = response()->view('webclubs.stories.show', compact('story', 'comments', 'likeStatus'));
        if (! Str::isUuid($visitor)) {
            $response->cookie('story_visitor', (string) Str::uuid(), 60 * 24 * 365, '/', null, $request->isSecure(), true, false, 'lax');
        }

        return $response;
    }

    public function comment(Request $request, int $story)
    {
        $story = $this->publishedStory($story);
        $data = $request->validate([
            'author_name' => ['required', 'string', 'max:100'],
            'author_email' => ['required', 'email', 'max:255'],
            'body' => ['required', 'string', 'max:2000'],
            'consent' => ['accepted'],
            'website' => ['nullable', 'max:0'],
        ]);
        $story->comments()->create([
            'author_name' => $data['author_name'], 'author_email' => $data['author_email'],
            'body' => $data['body'], 'consented_at' => now(), 'status' => 'pending',
        ]);

        return redirect()->route('webclubs.stories.show', $story)->with('message', 'Tu comentario está pendiente de aprobación.');
    }

    public function like(Request $request, int $story)
    {
        $story = $this->publishedStory($story);
        $visitor = $request->cookie('story_visitor', '');
        abort_unless(Str::isUuid($visitor), 422, 'Activa las cookies y vuelve a abrir la historia para marcar Me gusta.');
        $like = $story->likes()->firstOrCreate(['visitor_hash' => $this->visitorHash($visitor)], ['status' => 'pending']);
        $message = $like->wasRecentlyCreated ? 'Tu Me gusta está pendiente de aprobación.' : 'Ya has enviado un Me gusta para esta historia.';

        return redirect()->route('webclubs.stories.show', $story)->with('message', $message);
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
