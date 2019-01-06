<div>
    <a href="{{ route('character.show', ['character' => $message->sender]) }}">
        <div>
            <small>
                {{ $message->sender->name }}
            </small>
        </div>
        <div>
            <img class="profile-picture-msg" src="{{ asset($message->sender->getProfilePictureSmall()) }}" alt="Avatar">
        </div>
    </a>
    <div>
        <small>
            {{ $message->created_at->diffForHumans() }}
        </small>
    </div>
</div>