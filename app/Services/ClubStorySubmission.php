<?php

namespace App\Services;

use App\Models\ClubStory;
use App\Models\StoryCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class ClubStorySubmission
{
    public function store(int $schoolId, array $data, array $files): ClubStory
    {
        $paths = [];

        try {
            return DB::transaction(function () use ($schoolId, $data, $files, &$paths) {
                $name = Str::squish($data['category']);
                $slug = Str::slug($name);
                $category = StoryCategory::withoutGlobalScopes()->firstOrCreate(
                    ['sports_school_id' => $schoolId, 'slug' => $slug !== '' ? $slug : hash('sha256', mb_strtolower($name))],
                    ['name' => $name],
                );
                $story = ClubStory::create([
                    'sports_school_id' => $schoolId,
                    'story_category_id' => $category->id,
                    'author_name' => $data['author_name'],
                    'author_email' => $data['author_email'],
                    'title' => $data['title'],
                    'body' => $data['body'],
                    'consented_at' => now(),
                    'status' => 'pending',
                ]);

                foreach ($files as $position => $file) {
                    $path = $file->store("clubs/$schoolId/stories/$story->id", 'story-media');
                    if (! is_string($path) || $path === '') {
                        throw new RuntimeException('No se ha podido guardar el archivo de la historia.');
                    }
                    $paths[] = $path;
                    $story->media()->create([
                        'path' => $path,
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize(),
                        'position' => $position,
                    ]);
                }

                return $story;
            });
        } catch (Throwable $exception) {
            if ($paths !== []) {
                Storage::disk('story-media')->delete($paths);
            }
            throw $exception;
        }
    }
}
