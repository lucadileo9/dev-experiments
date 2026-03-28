<?php

namespace App\Http\Controllers;

use App\Http\Requests\IdeaRequest;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Notifications\IdeaCreated;
class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $ideas = Idea::all(); this is not safe because everyone can see all the ideas, even those created by other users
       // $ideas = Idea::where('user_id', Auth::id())->get(); // this way we only get the ideas created by the authenticated user
       // but still there are better ways to do this, using Eloquent relationships and eager loading
        $ideas = Auth::user()->ideas()->latest()->get(); // this way we get the ideas created by the authenticated user, ordered by creation date
       return view('ideas.index', compact('ideas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IdeaRequest $request)
    {
        $idea = Idea::create([
            'description' => $request->description,
            'status' => 'pending',
            'user_id' => Auth::id()
        ]);

        auth()->user()->notify(new IdeaCreated($idea));

        
        return redirect('/ideas')->with('success', 'Idea creata con successo!');
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     $idea = Idea::findOrFail($id);
    //     return view('ideas.show', compact('idea'));
    // }
    // Route Model Binding: Laravel resolve automatically the Idea instance based on the ID in the route
    public function show(Idea $idea)
    {
        Gate::authorize('view-idea', $idea); // this will check if the user is authorized to view the idea, if not it will throw a 403 error
        return view('ideas.show', compact('idea'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea)
    {
        // this search for the 'update' method in the IdeaPolicy and check if the user is authorized to update the idea, if not it will throw a 403 error
        Gate::authorize('update', $idea); 
        return view('ideas.edit', compact('idea'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IdeaRequest $request, Idea $idea)
    {
        $idea->update($request->validated());
        
        return redirect("/ideas/{$idea->id}")->with('success', 'Idea aggiornata con successo!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea)
    {
        $idea->delete();
        
        return redirect('/ideas')->with('success', 'Idea eliminata con successo!');
    }
}
