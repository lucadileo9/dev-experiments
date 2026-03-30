<?php

namespace App\Http\Controllers;

use App\Models\Step;
use Illuminate\Support\Facades\Gate;

class StepController extends Controller
{
    public function toggle(Step $step)
    {
        Gate::authorize('update', $step->idea);

        $step->update([
            'is_completed' => ! $step->is_completed,
        ]);

        return back();
    }
}
