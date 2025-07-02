<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Ajouter un historique
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <form action="{{ route('historique-productivites.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block">Date</label>
                <input type="date" name="date" class="w-full px-3 py-2 border rounded" required>
            </div>

            <div>
                <label class="block">Tâches terminées</label>
                <input type="number" name="taches_terminees" class="w-full px-3 py-2 border rounded" required>
            </div>

            <div>
                <label class="block">Score du jour</label>
                <input type="number" name="score_du_jour" class="w-full px-3 py-2 border rounded" required>
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Enregistrer</button>
        </form>
    </div>
</x-app-layout>
