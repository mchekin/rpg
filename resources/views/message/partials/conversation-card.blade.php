<div>
    <a href="{{ route('character.show', ['character' => $character]) }}">
        <div>
            <small>
                {{ $character->name }}
            </small>
        </div>
        <div>
            <img class="profile-picture-msg" src="{{ asset($character->getProfilePictureSmall()) }}" alt="Avatar">
        </div>
    </a>
    <div>
        <small>
            {{ $message->created_at->diffForHumans() }}
        </small>
    </div>
</div>