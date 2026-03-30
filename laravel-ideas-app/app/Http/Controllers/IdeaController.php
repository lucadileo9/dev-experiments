<?php

namespace App\Http\Controllers;

use App\IdeaStatus;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdeaController extends Controller
{
    public function index(Request $request)
    {
        // Validazione dello status
        $validatedStatus = $request->validate([
            'status' => ['nullable', 'in:pending,in_progress,completed'],
        ])['status'] ?? null;

        $query = Auth::user()->ideas();

        // Usare when per applicare il filtro condizionalmente
        $ideas = $query->when($validatedStatus, function ($q, $status) {
            $q->where('status', $status);
        })->get();

        // Contare le idee per ogni status
        $statusCounts = [
            'all' => Auth::user()->ideas()->count(),
            'pending' => Auth::user()->ideas()->where('status', IdeaStatus::PENDING)->count(),
            'in_progress' => Auth::user()->ideas()->where('status', IdeaStatus::IN_PROGRESS)->count(),
            'completed' => Auth::user()->ideas()->where('status', IdeaStatus::COMPLETED)->count(),
        ];

        return view('ideas.index', compact('ideas', 'statusCounts', 'validatedStatus'));
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
            'status' => ['required', 'in:pending,in_progress,completed'],
        ]);

        $idea = $request->user()->ideas()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('ideas.show', $idea)
            ->with('success', 'La tua idea è stata creata con successo!');
    }

    public function show(Idea $idea)
    {
        return view('ideas.show', compact('idea'));
    }

    public function edit(Idea $idea)
    {
        return view('ideas.edit', compact('idea'));
    }

    public function update(Request $request, Idea $idea)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255', 'min:5'],
            'description' => ['required', 'string', 'min:10'],
            'status' => ['required', 'in:pending,in_progress,completed'],
        ]);

        $idea->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'created_at' => now(),

        ]);

        return redirect()->route('ideas.show', $idea)
            ->with('success', 'La tua idea è stata aggiornata con successo!');
    }

    public function destroy(Idea $idea)
    {
        $idea->delete();

        return redirect()->route('ideas.index')
            ->with('success', 'La tua idea è stata eliminata!');
    }
}