<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" style="background-color: #343a40; color: white; height: 100vh; padding-top: 1rem;">
    <div class="sb-sidenav-menu">
        <div class="nav flex-column">

            <!-- Lien simple -->
            <a href="#" class="nav-link text-white d-flex align-items-center px-3 mb-2">
                <i class="fas fa-home me-2"></i>
                <span>Tableau de bord</span>
            </a>

            <!-- Titre de section -->
            <div class="sb-sidenav-menu-heading px-3 mt-3 mb-2 text-uppercase small">Gestion</div>

            <!-- Menu déroulant Tâches -->
            <a class="nav-link collapsed text-white px-3" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTaches" aria-expanded="false" aria-controls="collapseTaches">
                <i class="fas fa-tasks me-2"></i> Tâches
                <i class="fas fa-angle-down float-end"></i>
            </a>
            <div class="collapse" id="collapseTaches" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav flex-column ps-4">
                    <a class="nav-link text-white" href="{{ route('taches.index') }}">Liste des tâches</a>
                    <a class="nav-link text-white" href="{{ route('taches.create') }}">Ajouter une tâche</a>
                </nav>
            </div>

            <!-- Menu déroulant Productivité -->
            <a class="nav-link collapsed text-white px-3" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProductivite" aria-expanded="false" aria-controls="collapseProductivite">
                <i class="fas fa-chart-line me-2"></i> Productivité
                <i class="fas fa-angle-down float-end"></i>
            </a>
            <div class="collapse" id="collapseProductivite" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav flex-column ps-4">
                    <a class="nav-link text-white" href="{{ route('productivite.historique') }}">Historique</a>
                    <a class="nav-link text-white" href="{{ route('productivite.dashboard') }}">Évolution</a>
                </nav>
            </div>

            <!-- Menu déroulant Groupes -->
            <a class="nav-link collapsed text-white px-3" href="#" data-bs-toggle="collapse" data-bs-target="#collapseGroupes" aria-expanded="false" aria-controls="collapseGroupes">
                <i class="fas fa-users me-2"></i> Groupes
                <i class="fas fa-angle-down float-end"></i>
            </a>
            <div class="collapse" id="collapseGroupes" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav flex-column ps-4">

                    <!-- Lien vers groupes -->
                    <a class="nav-link text-white" href="{{ route('groupes.index') }}">Liste des groupes</a>

                    <!-- Groupes de l'utilisateur -->
                    @foreach(Auth::user()->groupes as $groupe)
                        <div class="ms-2 mt-3">
                            <span class="text-light fw-bold">{{ $groupe->nom }}</span>
                            <a class="nav-link text-white d-block ps-3" href="{{ route('groupes.inviter', ['groupe' => $groupe->id]) }}">➤ Inviter</a>
                            <a class="nav-link text-white d-block ps-3" href="{{ route('taches.createGroupe', $groupe) }}">➤ Tâche groupe</a>
                            <a class="nav-link text-white d-block ps-3" href="{{ route('taches.indexGroupe', $groupe) }}">➤ Liste tâche</a>
                            <a class="nav-link text-white d-block ps-3" href="{{ route('groupes.show', ['groupe' => $groupe->id]) }}">➤ Membres</a>
                        </div>
                    @endforeach

                    <!-- Invitations -->
                    <a class="nav-link text-white mt-2" href="{{ route('invitations.index') }}">Mes invitations</a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Pied de page -->
    <div class="sb-sidenav-footer text-white px-3 mt-auto">
        <div class="small">Connecté en tant que :</div>
        {{ Auth::user()->name ?? 'Invité' }}
    </div>
</nav>
