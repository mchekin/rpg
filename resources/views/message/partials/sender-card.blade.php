<div>
    {{ $message->sender->name }}
</div>
<div>
    <img class="profile-picture" src="{{ asset('svg/avatar.svg') }}" alt="Avatar">
</div>
<div>
    {{ $message->created_at }}
</div>