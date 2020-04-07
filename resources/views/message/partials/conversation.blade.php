<div class="message-list-container row mx-1 message {{$side}}">
    <div class="col-md-2 text-center">
        @include('message.partials.conversation-card', ['character' => $currentCharacter, 'message' => $message])
    </div>
    <div class="col-sm-8">
        @include('message.partials.conversation-message', ['character' => $otherCharacter->id, 'message' => $message])
    </div>
    <div class="col-md-2 text-center">
        @include('message.partials.conversation-card', ['character' => $otherCharacter, 'message' => $message])
    </div>
</div>
