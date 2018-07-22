<div class="message-list-container row">
    <div class="col-sm-2 text-center">
        @include('message.partials.sender-card', compact('message'))
    </div>
    <div class="col-sm-10">
        <p class="text-wrap">{!! $message->content !!}</p>
    </div>
</div>