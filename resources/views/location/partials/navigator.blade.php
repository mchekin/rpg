@php
    /** @var \App\Character $character */
    $character = Auth::user()->character;
@endphp

<form role="form" method="POST" class="mx-1">
    {!! csrf_field() !!}
    <div class="row mx-1 location-navigator mt-5 mb-5">
        <div class="col">
            <div class="row">
                <div class="col"></div>
                <div class="col text-center my-auto">
                    @if(!is_null($adjacent = $location->adjacent('north')))
                        <div>
                            <button type="submit"
                                    class="btn btn-link"
                                    formaction="{{ route('character.move', ['character' => $character, 'location' => $location->adjacent('north')]) }}">
                                {{ $location->adjacent('north')->name }}
                            </button>
                        </div>
                        <span class="fa fa-angle-up"></span>
                    @endif
                </div>
                <div class="col"></div>
            </div>

            <div class="row">
            </div>

            <div class="row">
                <div class="col text-right my-auto">
                    @if(!is_null($adjacent = $location->adjacent('west')))
                        <div>
                            <button type="submit"
                                    class="btn btn-link"
                                    formaction="{{ route('character.move', ['character' => $character, 'location' => $location->adjacent('west')]) }}">
                                {{ $location->adjacent('west')->name }}
                            </button>
                            <span class="fa fa-angle-left"></span>
                        </div>
                    @endif
                </div>
                <div class="col text-center my-auto"><span class="fas fa-walking fa-2x"></span></div>
                <div class="col text-left my-auto">
                    @if(!is_null($adjacent = $location->adjacent('east')))
                        <div>
                            <span class="fa fa-angle-right"></span>
                            <button type="submit"
                                    class="btn btn-link"
                                    formaction="{{ route('character.move', ['character' => $character, 'location' => $location->adjacent('east')]) }}">
                                {{ $location->adjacent('east')->name }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
            </div>

            <div class="row">
                <div class="col"></div>
                <div class="col text-center my-auto">
                    @if(!is_null($adjacent = $location->adjacent('south')))
                        <span class="fa fa-angle-down"></span>
                        <div>
                            <button type="submit"
                                    class="btn btn-link"
                                    formaction="{{ route('character.move', ['character' => $character, 'location' => $location->adjacent('south')]) }}">
                                {{ $location->adjacent('south')->name }}
                            </button>
                        </div>
                    @endif
                </div>
                <div class="col"></div>
            </div>

        </div>

    </div>
</form>
