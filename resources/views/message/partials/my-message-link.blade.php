<div class="message-list-container row">
    <div class="col-md-2 text-center">
        @include('message.partials.sender-card', compact('message'))
    </div>
    <div class="col-md-10">
        <a href="{{ route('character.message.index', ['character' => $message->recipient->character]) }}">
            <p>
                {!! $message->content !!}
            </p>
        </a>
    </div>
</div>