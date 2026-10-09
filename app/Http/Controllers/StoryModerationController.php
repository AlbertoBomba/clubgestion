<?php

namespace App\Http\Controllers;

use App\Models\ClubStory;
use App\Models\StoryComment;
use App\Models\StoryLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class StoryModerationController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('moderate-club-stories');
        $filters = $request->validate([
            'kind' => ['nullable', 'in:stories,comments,likes'],
            'status' => ['nullable', 'in:pending,approved,rejected,all'],
        ]);
        $kind = $filters['kind'] ?? 'stories';
        $status = $filters['status'] ?? 'pending';
        $query = $this->query($kind);
        if ($kind === 'stories') {
            $query->with(['category' => fn ($query) => $query->withoutGlobalScopes()])->withCount(['comments', 'likes']);
        } else {
            $query->with(['story' => fn ($query) => $query->withoutGlobalScopes()]);
        }
        $items = $query->when($status !== 'all', fn ($query) => $query->where('status', $status))
            ->latest()->paginate(20)->withQueryString();
        $pending = [];
        foreach (['stories', 'comments', 'likes'] as $type) {
            $pending[$type] = $this->query($type)->where('status', 'pending')->count();
        }

        return view('stories.index', compact('items', 'kind', 'status', 'pending'));
    }

    public function show(int $story)
    {
        Gate::authorize('moderate-club-stories');
        $story = $this->query('stories')->with([
            'category' => fn ($query) => $query->withoutGlobalScopes(), 'media',
        ])->findOrFail($story);
        $comments = $story->comments()->latest()->paginate(15, ['*'], 'comments_page');
        $likes = $story->likes()->latest()->paginate(20, ['*'], 'likes_page');

        return view('stories.show', compact('story', 'comments', 'likes'));
    }

    public function review(Request $request, string $kind, int $item)
    {
        Gate::authorize('moderate-club-stories');
        abort_unless(in_array($kind, ['stories', 'comments', 'likes'], true), 404);
        $data = $request->validate([
            'status' => ['required', 'in:approved,rejected'],
            'review_note' => ['nullable', 'string', 'max:1000'],
        ]);
        $record = $this->query($kind)->findOrFail($item);
        $update = [
            'status' => $data['status'],
            'review_note' => $data['review_note'] ?? null,
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ];
        if ($kind === 'stories') {
            $update['published_at'] = $data['status'] === 'approved' ? ($record->published_at ?? now()) : null;
        }
        $record->update($update);

        return back()->with('message', 'Moderación guardada correctamente.');
    }

    private function query(string $kind)
    {
        $schoolId = auth()->user()->sports_school_id;
        if ($kind === 'stories') {
            return ClubStory::withoutGlobalScopes()->where('sports_school_id', $schoolId);
        }
        $model = $kind === 'comments' ? StoryComment::class : StoryLike::class;

        return $model::query()->whereHas('story', fn ($query) => $query->withoutGlobalScopes()->where('sports_school_id', $schoolId));
    }
}
