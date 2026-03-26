<?php

namespace App\Http\Controllers;

use App\Http\Requests\IdeaRequest;
use App\Models\Idea;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ideas = Idea::all();
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
        Idea::create($request->validated());
        
        return redirect('/ideas')->with('success', 'Idea creata con successo!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $idea = Idea::findOrFail($id);
        return view('ideas.show', compact('idea'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $idea = Idea::findOrFail($id);
        return view('ideas.edit', compact('idea'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IdeaRequest $request, string $id)
    {
        $idea = Idea::findOrFail($id);
        $idea->update($request->validated());
        
        return redirect("/ideas/{$id}")->with('success', 'Idea aggiornata con successo!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Idea::destroy($id);
        
        return redirect('/ideas')->with('success', 'Idea eliminata con successo!');
    }
}
