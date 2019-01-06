@extends("base")

@section("head")
    <title>Conversation with {{$character->name}}</title>
    @parent
@stop

@section("body")

    <div class="col-lg-10 offset-md-1 col-md-12 mt-3">

        <div class="column">
            <form role="form" method="POST" action="{{ URL::route('character.message.store', compact('character')) }}">
                {!! csrf_field() !!}
                <div class="form-group row">
                    <label for="content" class="sr-only">Message</label>
                    <textarea maxlength="{{ $contentLimit }}"
                              class="form-control countdown" placeholder="Write something to {{$character->name}} ..."
                              required autofocus name="content"
                              rows="7"></textarea>
                </div>
                <div class="row">
                    <button type="submit" class="btn btn-success btn-block">Send</button>
                </div>
            </form>
        </div>

        <div class="column">
            @foreach ($messages as $message)
                @if((int)$message->from_id === (int)$currentCharacter->id)
                    @include('message.partials.my-message', compact('message'))
                @else
                    @include('message.partials.others-message', compact('message'))
                @endif
            @endforeach
            {{ $messages->links() }}
        </div>

    </div>

@stop

@section("footer")
    @parent

    <script src="{{ asset('js/vcountdown.js') }}"></script>
    <script>
        VCountdown({
            target: '.countdown',
            maxChars: '{{ $contentLimit }}'
        });
    </script>
@stop