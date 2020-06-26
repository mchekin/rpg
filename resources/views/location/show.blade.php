@extends('base')

@section('head')
    <title>{{ $location->name }}</title>
    @parent
@stop

@section('body')

    <div class="row mx-1">
        <div class="col-lg-6">
            <h5 class="text-center">{{ $location->name }}</h5>
            <hr>
            <p>{{ $location->description }}</p>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <img class="img-fluid" src="{{ asset('images/'.$location->image) }}">
                </div>
            </div>

            @include('location.partials.navigator', compact('location'))

        </div>

        <div class="col-lg-6">
            <h5 class="text-center">Local characters:</h5>
            <hr>
            <form role="form" method="POST" class="mx-1">
                {!! csrf_field() !!}
                <ul class="list-group">

                    {!! csrf_field() !!}
                    @foreach($location->characters as $character)
                        @include('location.partials.list-character', compact('character'))
                    @endforeach
                </ul>
            </form>
        </div>
    </div>

@stop
