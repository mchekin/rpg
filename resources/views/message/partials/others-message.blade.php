<div class="message-list-container message-list-darker row">
    <div class="col-md-10">
        <p>{!! $message->content !!}</p>
    </div>
    <div class="col-md-2 text-center">
        <div class="clearfix">
            <img class="profile-picture" src="{{ asset('svg/avatar.svg') }}" alt="Avatar">
        </div>
        <div>{{ $message->created_at }}</div>
    </div>
</div>