<x-layout title="Home">
    <h1>Insert your ideas here</h1>

    <x-form.errors :errors="$errors" />

    <form action="/ideas" method="POST">
        @csrf
        <div class="col-span-full">
          <div class="mt-2">
            <textarea id="description" name="description" rows="3" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6"></textarea>
          </div>
          <p class="mt-3 text-sm/6 text-gray-400">Write a few sentences about yourself.</p>
        </div>
        <div class="mt-6 flex items-center gap-x-6">
            <button type="submit" class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Save</button>
        </div>
    </form>

    {{-- @if (count($ideas)) --}}
    @if ($ideas->count())
    <div class="mt-10">
        <h2 class="text-lg font-medium leading-6 text-white">Your Ideas</h2>
        <ul>
            @foreach ($ideas as $idea)
                <li><a href="/ideas/{{ $idea->id }}" class="text-blue-500 hover:underline">{{ $idea->description }}</a></li>
            @endforeach
        </ul>
    @else
        <h2 class="text-lg font-medium leading-6 text-white">No Ideas</h2>
    </div>
    @endif
</x-layout>
