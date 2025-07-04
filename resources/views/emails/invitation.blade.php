<h2>Invitation à rejoindre le groupe {{ $invitation->groupe->nom }}</h2>

<p>Bonjour,</p>

<p>
    Vous avez été invité à rejoindre le groupe <strong>{{ $invitation->groupe->nom }}</strong>.
</p>

<p>
    Cliquez sur le lien suivant pour accepter l'invitation :
</p>

<p>
    <a href="{{ url('/invitations/accepter/' . $invitation->token) }}">
        Accepter l'invitation
    </a>
</p>

<p>Merci !</p>
