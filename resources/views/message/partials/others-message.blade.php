<div class="message-list-container row message right">
    <div class="col-sm-10">
        <div class="text_wrapper">
            <p class="text-wrap">{!! $message->content !!}</p>
        </div>
    </div>
    <div class="col-sm-2 text-center">
        @include('message.partials.conversation-card', ['character' => $message->sender, 'message' => $message])
    </div>
</div>