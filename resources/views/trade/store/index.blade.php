@extends('base')

@section('head')
    <title>Store</title>
    @parent
@stop

@section('body')

    <store-trade :customer="{{ $customer->load('inventory.items') }}" :trader="{{ $trader->load('store.items') }}"></store-trade>

    <div class="row">

        <!-- Left Side -->
        <div class="col-md-6">
        </div>

        <!-- Right Side -->
        <div class="col-md-6">
        </div>

    </div>

@stop

@section('footer')
    @parent

@stop
