@extends("base")

@section("head")
    <title>Conversation with {{$character->name}}</title>
    @parent
@stop

@section("body")

    <div class="col-lg-10 offset-md-1 col-md-12">

        <div class="column">
            <form role="form" method="POST" action="{{ URL::route('character.message.store', compact('character')) }}">
                {!! csrf_field() !!}
                <div class="form-group row">
                    <label for="content" class="sr-only">Message</label>
                    <textarea class="form-control" placeholder="Write something to {{$character->name}} ..."
                              required autofocus name="content" rows="3"></textarea>
                </div>
                <div class="row">
                    <button type="submit" class="btn btn-success btn-block">Send</button>
                </div>
            </form>
        </div>

        <div class="column">
            @foreach ($messages as $message)
                @if((int)$message->from_id === (int)$currentUser->id)
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

    {{--<script src="{{ asset('js/message-update.js') }}"></script>--}}
@stop