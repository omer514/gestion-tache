@extends('layouts.master')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="container mt-4">
    <h2>Inviter un utilisateur dans le groupe : {{ $groupe->nom }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ url('/groupes/' . $groupe->id . '/inviter') }}">
            @csrf
            <input type="email" name="email" required placeholder="Email de l'utilisateur à inviter">
            <button type="submit">Envoyer l’invitation</button>
</form>

</div>
@endsection
