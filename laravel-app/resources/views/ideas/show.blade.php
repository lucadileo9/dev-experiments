<x-layout title="Home">
    <h1>Your ideas here</h1>

    <div class="mt-10">
        <ul>
                <li>{{ $idea->description }}</li>
        </ul>
    </div>
    <button class="mt-8 rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
        <a href="/ideas/{{ $idea->id }}/edit">Edit</a>


</x-layout>
