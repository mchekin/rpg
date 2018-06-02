@extends("base")

@section("head")
    <title>Conversation with {{$character->name}}</title>
    @parent
@stop

<?php
        /** @var \App\Character $currentUserCharacter */
        /** @var \App\Character $character */
        $othersMessages = $currentUserCharacter->user->received()->from($character->user)->get();
        $myMessages = $character->user->received()->from($currentUserCharacter->user)->get();

        $allConversationMessages = $myMessages->merge($othersMessages)->sortByDesc('created_at');
?>

@section("body")

    <div class="col-md-10 col-md-offset-1 col-sm-12">

        <div class="row">
            <form role="form" method="POST" action="{{ URL::route('character.message.store', compact('character')) }}">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="content" class="sr-only">Message</label>
                    <textarea class="form-control" placeholder="Write something to {{$character->name}} ..." required="" autofocus="" name="content" rows="3"></textarea>
                </div>
                <div>
                    <button type="submit" class="btn btn-success btn-block">Send</button>
                </div>
            </form>
        </div>

        <div class="row">
            @foreach ($allConversationMessages as $message)
                @if((int)$message->from_id === (int)$currentUserCharacter->user->id)
                    <div class="message-list-container">
                        <img src="https://vignette.wikia.nocookie.net/forgottenrealms/images/f/fa/Jon_Irenicus.jpg" alt="Avatar">
                        <p>{!! $message->content !!}</p>
                        <span class="message-list-time-right">{{ $message->created_at }}</span>
                    </div>
                @else
                    <div class="message-list-container message-list-darker">
                        <img src="https://vignette.wikia.nocookie.net/forgottenrealms/images/9/95/Sarevok_-_Throne_of_Bhaal.png" alt="Avatar" class="right">
                        <p>{!! $message->content !!}</p>
                        <span class="message-list-time-left">{{ $message->created_at }}</span>
                    </div>
                @endif
            @endforeach
        </div>

    </div>

@stop

@section("footer")
    @parent

    {{--<script src="{{ asset('js/message-update.js') }}"></script>--}}
@stop