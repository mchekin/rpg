@extends('base')

@section('head')
    <title>Store</title>
    @parent
@stop

@section('body')
    <div class="row">

        <!-- Left Side -->
        <div class="col-md-6">

            @include('trade.partials.inventory', compact('character'))

            <form role="form" method="POST">
                {!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-12 text-center my-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold">
                                    Money in inventory: {{ $character->inventory->money }}
                                </span>
                            </div>
                            <label for="money-to-store"></label>
                            <input type="number"
                                   name="money_amount"
                                   id="money-to-store"
                                   class="form-control"
                                   value="0"
                                   min="0"
                                   max="{{ $character->inventory->money }}"
                                   aria-label="Money to move to store">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <button type="submit"
                                            class="btn btn-sm btn-secondary"
                                            formaction="{{ route('inventory.money.move-to-store') }}">
                                        Move to Store
                                         <span class="fas fa-long-arrow-alt-right"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="text-center my-3">
                <a class="btn btn-sm btn-primary" href="{{  route('character.show',  compact('character')) }}">
                    Back to Profile
                    <span class="fa fa-arrow-left"></span>
                </a>
            </div>

        </div>


        <!-- Right Side -->
        <div class="col-md-6">

            @include('trade.partials.store', compact('character'))


            <form role="form" method="POST">
                {!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-12 text-center my-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <button type="submit"
                                            class="btn btn-sm btn-secondary"
                                            formaction="{{ route('store.money.move-to-inventory') }}">
                                        <span class="fas fa-long-arrow-alt-left"></span>
                                        Move to Inventory
                                    </button>
                                </span>
                            </div>
                            <label for="money-to-inventory"></label>
                            <input type="number"
                                   name="money_amount"
                                   id="money-to-inventory"
                                   class="form-control"
                                   value="{{ $character->store->money }}"
                                   min="0"
                                   max="{{ $character->store->money }}"
                                   aria-label="Money to move to inventory">
                            <div class="input-group-append">
                                <span class="input-group-text font-weight-bold">
                                    Money in store: {{ $character->store->money }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

@stop

@section('footer')
    @parent

@stop
