<div class="message-list-container row">
    <div class="col-md-2 text-center">
        @include('message.partials.sender-card', compact('message'))
    </div>
    <div class="col-md-10">
        <a class="d-block w-100 h-100"
           href="{{ route('character.message.index', ['character' => $message->to_id]) }}">
            <p class="text-wrap">{!! $message->content !!}</p>
        </a>
    </div>
</div>