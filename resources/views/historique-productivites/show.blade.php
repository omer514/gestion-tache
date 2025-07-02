<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Détail de l'historique
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 space-y-4">
        <p><strong>Utilisateur :</strong> {{ $historiqueProductivite->user->name ?? 'N/A' }}</p>
        <p><strong>Date :</strong> {{ $historiqueProductivite->date }}</p>
        <p><strong>Tâches terminées :</strong> {{ $historiqueProductivite->taches_terminees }}</p>
        <p><strong>Score du jour :</strong> {{ $historiqueProductivite->score_du_jour }}</p>

        <a href="{{ route('historique-productivites.index') }}" class="text-blue-600 hover:underline">← Retour à la liste</a>
    </div>
</x-app-layout>
