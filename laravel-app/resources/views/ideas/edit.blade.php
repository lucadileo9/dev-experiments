<x-layout title="Home">
    <h1>Modify Idea</h1>

    <form action="/ideas/{{ $idea->id }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="col-span-full">
          <div class="mt-2">
            <textarea id="idea" name="idea" rows="3" 
                class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6">
                {{ $idea->description }}
            </textarea>
          </div>
          <p class="mt-3 text-sm/6 text-gray-400">Write a few sentences about yourself.</p>
        </div>
        <div class="mt-6 flex items-center gap-x-6">
            <button type="submit" class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Save</button>
            <button type="sumbit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded border-b-4 border-red-700" form="delete-idea-form">Delete</button>
        </div>
    </form>

    <form action="/ideas/{{ $idea->id }}" method="POST" class="mt-6" id="delete-idea-form">
        @csrf
        @method('DELETE')
</x-layout>
