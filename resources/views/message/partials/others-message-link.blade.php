<div class="message-list-container message-list-darker">
    <a href="{{ route('character.message.index', ['character' => $message->sender->character]) }}">
        <div class="col-sm-10">
            <p>{!! $message->content !!}</p>
        </div>
    </a>
    <div class="col-sm-2 text-center">
        <div class="clearfix">
            <img src="{{ asset('svg/avatar.svg') }}" alt="Avatar">
        </div>
        <div>{{ $message->created_at }}</div>
    </div>
</div>