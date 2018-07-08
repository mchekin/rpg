<div class="message-list-container message-list-darker row">
    <div class="col-md-10">
        <a href="{{ route('character.message.index', ['character' => $message->sender]) }}">
            <p>{!! $message->content !!}</p>
        </a>
    </div>
    <div class="col-md-2 text-center">
        @include('message.partials.sender-card', compact('message'))
    </div>
</div>