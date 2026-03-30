<?php

namespace App\Action;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CreateIdea
{
	public function handle(array $attributes, ?User $user = null)
	{
		/* @var User */
		$user ??= Auth::user();

		$data = collect($attributes)->only([
			'title', 'description', 'status', 'links',
		])->toArray();

		if ($attributes['image'] ?? false) {
			$data['image_path'] = $attributes['image']->store('ideas', 'public');
		}

		$idea = $user->ideas()->create($data);

		$steps = collect($attributes['steps'] ?? [])->map(fn ($step) => ['title' => $step]);

		$idea->steps()->createMany($steps);

        return $idea;
	}
}