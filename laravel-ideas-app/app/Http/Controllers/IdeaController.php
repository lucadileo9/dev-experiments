<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    public function index()
    {
        $ideas = Idea::with('user')->latest()->paginate(12);

        return view('ideas.index', compact('ideas'));
    }

    public function create()
    {
        return view('ideas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255', 'min:5'],
            'description' => ['required', 'string', 'min:10'],
        ]);

        $idea = $request->user()->ideas()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => 'pending',
        ]);

        return redirect()->route('ideas.show', $idea)
            ->with('success', 'La tua idea è stata creata con successo!');
    }

    public function show(Idea $idea)
    {
        return view('ideas.show', compact('idea'));
    }
}
