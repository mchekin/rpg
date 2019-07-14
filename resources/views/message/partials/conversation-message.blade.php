<a class="d-block w-100 h-100"
       href="{{ route('character.message.index', ['character' => $otherCharacter->id]) }}">
        <div class="text_wrapper">
            <p class="text-wrap">{!! $message->content !!}</p>
        </div>
</a>