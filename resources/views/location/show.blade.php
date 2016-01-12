@extends("base")

@section("head")
    <title>{{ $location->name }}</title>
    @parent
@stop

@section("body")

    <div class="col-md-6">
        <h2>{{ $location->name }}</h2>
        <hr>
        <img class="img-responsive col-md-8 col-md-offset-2" src="{{ asset('images/'.$location->image) }}">
    </div>

    <div class="col-md-6">
        <h2>Characters at this location:</h2>
        <hr>
        <div class="list-group">
            @foreach($location->characters as $character)
                <a href="#" class="list-group-item">
                    {{ $character->name }} ({{ $character->race->name }} {{ $character->gender }})
                </a>
            @endforeach
        </div>
    </div>

@stop