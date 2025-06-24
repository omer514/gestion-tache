@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Bienvenue dans votre espace</h1>
    <p class="mb-4">Voici le résumé de vos tâches et performances.</p>

    {{-- Cartes de résumé --}}
    <div class="row">
        <div class="col-xl-4 mb-4">
            <div class="card bg-warning text-white h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Tâches en cours</h5>
                        <h2>{{ $tachesEnCours ?? 0 }}</h2>
                    </div>
                    <i class="fas fa-spinner fa-3x"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-4 mb-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Tâches terminées</h5>
                        <h2>{{ $tachesTerminees ?? 0 }}</h2>
                    </div>
                    <i class="fas fa-check fa-3x"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-4 mb-4">
            <div class="card bg-danger text-white h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Tâches urgentes</h5>
                        <h2>{{ $tachesUrgentes ?? 0 }}</h2>
                    </div>
                    <i class="fas fa-bolt fa-3x"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
