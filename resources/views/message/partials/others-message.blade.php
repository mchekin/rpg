<div class="message-list-container message-list-darker row">
    <div class="col-md-10">
        <p class="text-wrap">{!! $message->content !!}</p>
    </div>
    <div class="col-md-2 text-center">
        @include('message.partials.sender-card', compact('message'))
    </div>
</div>