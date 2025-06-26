<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" style="background-color: #343a40; color: white; height: 100vh; padding-top: 1rem;">
    <div class="sb-sidenav-menu">
        <div class="nav flex-column">

            <!-- Lien simple -->
            <a href="#" class="nav-link text-white d-flex align-items-center px-3 mb-2">
                <i class="fas fa-home me-2"></i>
                <span>Tableau de bord</span>
            </a>

            <!-- Titre section -->
            <div class="sb-sidenav-menu-heading px-3 mt-3 mb-2 text-uppercase small">Gestion</div>

            <!-- Menu déroulant Tâches -->
            <a class="nav-link collapsed d-flex justify-content-between align-items-center px-3" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTaches" aria-expanded="false" aria-controls="collapseTaches" style="color: white;">
                <div><i class="fas fa-tasks me-2"></i>Tâches</div>
                <i class="fas fa-angle-down"></i>
            </a>
            <div class="collapse" id="collapseTaches" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav flex-column px-4">
                    <a class="nav-link text-white" href="#">Liste des tâches</a>
                    <a class="nav-link text-white" href="#">Ajouter une tâche</a>
                </nav>
            </div>

            <!-- Menu déroulant Tâches -->
            <a class="nav-link collapsed d-flex justify-content-between align-items-center px-3" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTaches" aria-expanded="false" aria-controls="collapseTaches" style="color: white;">
                <div><i class="fas fa-tasks me-2"></i>Tâches Groupes</div>
                <i class="fas fa-angle-down"></i>
            </a>
            <div class="collapse" id="collapseTaches" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav flex-column px-4">
                    <a class="nav-link text-white" href="{{ route('tachegroupes.index') }}">Liste des tâches Partagés</a>
                    <a class="nav-link text-white" href="{{ route('tachegroupes.create')}}">Partager une tâche</a>
                    <li><a href="{{ route('groupes.index') }}">👥 Groupes</a></li>

                </nav>
            </div>

            <!-- Autre section -->
            <div class="sb-sidenav-menu-heading px-3 mt-3 mb-2 text-uppercase small">Autres modules</div>

            <a class="nav-link collapsed d-flex justify-content-between align-items-center px-3" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAutres" aria-expanded="false" aria-controls="collapseAutres" style="color: white;">
                <div><i class="fas fa-layer-group me-2"></i>Autres</div>
                <i class="fas fa-angle-down"></i>
            </a>
            <div class="collapse" id="collapseAutres" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav flex-column px-4">
                    <a class="nav-link text-white" href="#">Lien 1</a>
                    <a class="nav-link text-white" href="#">Lien 2</a>
                </nav>
            </div>

        </div>
    </div>

    <div class="sb-sidenav-footer px-3 mt-auto text-white">
        <div class="small">Connecté en tant que :</div>
        {{ Auth::user()->name ?? 'Invité' }}
    </div>
</nav>
