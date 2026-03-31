<?php

namespace App\Action;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UpdateIdea
{
	public function handle(Idea $idea, array $attributes, ?User $user = null): Idea
	{
        /** @var \App\Models\User $user */
		$user ??= Auth::user();

		// Autorizzazione
		if ($idea->user_id !== $user->id) {
			abort(403, '>Not authorized to update this idea');
		}

		$data = collect($attributes)->only([
			'title', 'description', 'status', 'links',
		])->toArray();

		if ($attributes['image'] ?? false) {
			// If there's a new image, delete the old one if it exists
			if ($idea->image_path && Storage::disk('public')->exists($idea->image_path)) {
				Storage::disk('public')->delete($idea->image_path);
			}
			// Save the new image and update the path
			$data['image_path'] = $attributes['image']->store('ideas', 'public');
		}

		$idea->update($data);

		$idea->steps()->delete();
		$steps = collect($attributes['steps'] ?? [])->map(fn ($step) => ['title' => $step]);
		$idea->steps()->createMany($steps);

        return $idea;
	}
}
