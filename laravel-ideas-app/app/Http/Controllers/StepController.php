<?php

namespace App\Http\Controllers;

use App\Models\Step;
use Illuminate\Http\Request;

class StepController extends Controller
{
    public function toggle(Step $step)
    {
        $step->update([
            'is_completed' => !$step->is_completed,
        ]);

        return back();
    }
}
