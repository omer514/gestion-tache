<!-- resources/views/historique-productivites/index.blade.php -->

<x-app-layout>
    <!-- Titre de la page -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Mon évolution
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-4">Historique de Productivité</h1>

        <a href="{{ route('historique-productivites.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Ajouter un historique
        </a>

        <table class="mt-4 w-full border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-4 py-2">Utilisateur</th>
                    <th class="border px-4 py-2">Date</th>
                    <th class="border px-4 py-2">Tâches terminées</th>
                    <th class="border px-4 py-2">Score du jour</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($historiques as $historique)
                    <tr class="text-center">
                        <td class="border px-4 py-2">{{ $historique->user->name ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ $historique->date }}</td>
                        <td class="border px-4 py-2">{{ $historique->taches_terminees }}</td>
                        <td class="border px-4 py-2">{{ $historique->score_du_jour }}</td>
                        <td class="border px-4 py-2 space-x-2">
                            <a href="{{ route('historique-productivites.show', $historique) }}" class="text-blue-500 hover:underline">Voir</a>
                            <a href="{{ route('historique-productivites.edit', $historique) }}" class="text-yellow-500 hover:underline">Modifier</a>
                            <form action="{{ route('historique-productivites.destroy', $historique) }}" method="POST" class="inline-block" onsubmit="return confirm('Supprimer cet historique ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
