<x-layouts.app title="Nuova Idea - DevIdeas">

    <x-ui.section class="max-w-2xl mx-auto mt-8">
        <x-ui.title>Proponi una Nuova Idea</x-ui.title>

        <form action="{{ route('ideas.store') }}" method="POST">
            @csrf
            
            <!-- Usiamo i componenti form che avevi -->
            <div class="mb-4">
                <x-form.input name="title" label="Titolo dell'idea" placeholder="Es. Applicazione per gestire il bucato" required />
            </div>

            <div class="mb-6">
                <!-- Se hai il componente x-form.textarea usiamo quello, altrimenti input o nativo -->
                <x-form.textarea name="description" label="Descrizione dettagliata" rows="5" placeholder="Descrivi il problema che risolve e le funzionalità chiave..." required></x-form.textarea>
            </div>

            <div class="flex justify-end gap-2 mt-8">
                <a href="{{ url()->previous() }}" class="btn btn-ghost">Annulla</a>
                <button type="submit" class="btn btn-primary">Salva Idea</button>
            </div>
        </form>
    </x-ui.section>

</x-layouts.app>