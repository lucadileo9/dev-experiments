<?php

namespace App\Http\Controllers;

use App\Action\CreateIdea;
use App\Action\UpdateIdea;
use App\Http\Requests\IdeaRequest;
use App\IdeaStatus;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class IdeaController extends Controller
{
    public function index(Request $request)
    {
        // Validazione dello status
        $validatedStatus = $request->validate([
            'status' => ['nullable', Rule::enum(IdeaStatus::class)],
        ])['status'] ?? null;

        /** @var User $user */
        $user = Auth::user();
        $query = $user->ideas();

        // Usare when per applicare il filtro condizionalmente
        $ideas = $query->when($validatedStatus, function ($q, $status): void {
            $q->where('status', $status);
        })->get();

        // Contare le idee per ogni status tramite raggruppamento
        $statusGroupCounts = $user->ideas()
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $statusCounts = [
            'all' => $statusGroupCounts->sum(),
            'pending' => $statusGroupCounts->get(IdeaStatus::PENDING->value) ?? 0,
            'in_progress' => $statusGroupCounts->get(IdeaStatus::IN_PROGRESS->value) ?? 0,
            'completed' => $statusGroupCounts->get(IdeaStatus::COMPLETED->value) ?? 0,
        ];

        return view('ideas.index', compact('ideas', 'statusCounts', 'validatedStatus'));
    }

    public function store(IdeaRequest $request, CreateIdea $createIdea)
    {
        $idea = $createIdea->handle($request->validated());

        return redirect()->route('ideas.show', $idea)
            ->with('success', 'Your idea has been created successfully!');
    }

    public function show(Idea $idea)
    {
        Gate::authorize('view', $idea);

        $idea->load('steps');

        return view('ideas.show', compact('idea'));
    }

    public function update(Idea $idea, IdeaRequest $request, UpdateIdea $updateIdea)
    {
        $updatedIdea = $updateIdea->handle($idea, $request->validated());

        return redirect()->route('ideas.show', $updatedIdea)
            ->with('success', 'Your idea has been updated successfully!');
    }

    public function destroy(Idea $idea)
    {
        Gate::authorize('delete', $idea);

        $idea->delete();

        return redirect()->route('ideas.index')
            ->with('success', 'Your idea has been deleted!');
    }

    public function deleteImage(Idea $idea)
    {
        Gate::authorize('update', $idea);

        if ($idea->image_path) {
            $idea->deleteImage();
        }

        return back()->with('success', 'The image has been deleted successfully!');
    }
}
