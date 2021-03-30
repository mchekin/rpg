@extends('base')

@section('head')
    <title>Store</title>
    @parent
@stop

@section('body')

    <store-management :character="{{ $character->load('inventory.items', 'store.items') }}"></store-management>

    <div class="row">

        <!-- Left Side -->
        <div class="col-md-6">

            <div class="text-center my-3">
                <a class="btn btn-sm btn-primary" href="{{  route('character.show',  compact('character')) }}">
                    Back to Profile
                    <span class="fa fa-arrow-left"></span>
                </a>
            </div>

        </div>

        <!-- Right Side -->
        <div class="col-md-6">
        </div>

    </div>

@stop

@section('footer')
    @parent

@stop
