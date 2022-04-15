@extends('base')

@section('head')
    <title>Inventory</title>
    @parent
@stop

@section('body')
    <div class="row">

        <!-- Left Side -->
        <div class="col-md-6">

            <inventory-management :character="{{ $character->load('inventory.items') }}"></inventory-management>

        </div>


        <!-- Right Side -->
        <div class="col-md-6">

            @include('character.partials.general', compact('character', 'level'))

            @include('character.partials.attributes', compact('character'))

            @include('character.partials.statistics', compact('character'))

        </div>

    </div>

@stop

@section('footer')
    @parent

@stop
