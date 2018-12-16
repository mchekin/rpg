<div>
    <a href="{{ route('character.show', ['character' => $message->sender]) }}">
        {{ $message->sender->name }}
    </a>
</div>
<div>
    <img class="profile-picture" src="{{ asset($message->sender->getProfilePictureSmall()) }}" alt="Avatar">
</div>
<div>
    <small>
        {{ $message->created_at }}
    </small>
</div>