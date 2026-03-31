<?php

namespace App\Action;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CreateIdea
{
	public function handle(array $attributes, ?User $user = null)
	{
        /** @var \App\Models\User $user */
		$user ??= Auth::user();

		$data = collect($attributes)->only([
			'title', 'description', 'status', 'links',
		])->toArray();

		$data['description'] = $this->formatDescription($data['description']);

		if ($attributes['image'] ?? false) {
			$data['image_path'] = $attributes['image']->store('ideas', 'public');
		}

		$idea = $user->ideas()->create($data);

		$steps = collect($attributes['steps'] ?? [])->map(fn ($step) => ['title' => $step]);

		$idea->steps()->createMany($steps);

        return $idea;
	}

	private function formatDescription(string $description): string
	{
		return str($description)->markdown();
	}
}