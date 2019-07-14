@extends("base")

@section("head")
    <title>Inbox</title>
    @parent
@stop

@section("body")

    <div class="col-lg-10 offset-md-1 col-md-12 mt-3">
        <div>
            <ul class="messages">
                @forelse ($messages as $message)
                    @php
                        list($otherCharacter, $side) = ($message->sender->id === $currentCharacter->id)
                            ? [$message->recipient, 'left']
                            : [$message->sender, 'right'];
                    @endphp
                    @include('message.partials.conversation', compact(
                        'message',
                        'currentCharacter',
                        'otherCharacter',
                        'side'
                    ))
                @empty
                    @include('message.partials.no-messages')
                @endforelse
                {{ $messages->links() }}
            </ul>
        </div>
    </div>

@stop