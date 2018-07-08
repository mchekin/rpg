<div class="row location-navigator mt-5 mb-5">
    <div class="col">
        <div class="row">
            <div class="col"></div>
            <div class="col text-center my-auto">
                @if(!is_null($adjacent = $location->adjacent('north')))
                    <div>
                        <a href="{{ route('character.move', ['character' => Auth::user()->character, 'location' => $location->adjacent('north')]) }}">
                            {{ $location->adjacent('north')->name }}
                        </a>
                    </div>
                    <span class="fa fa-angle-up"></span>
                @endif
            </div>
            <div class="col"></div>
        </div>

        <div class="row">
            <div class="col text-center my-auto">
                @if(!is_null($adjacent = $location->adjacent('west')))
                    <div>
                        <span class="fa fa-angle-left"></span>
                        <a href="{{ route('character.move', ['character' => Auth::user()->character, 'location' => $location->adjacent('west')]) }}">
                            {{ $location->adjacent('west')->name }}
                        </a>
                    </div>
                @endif
            </div>
            <div class="col text-center my-auto"><span class="fas fa-walking fa-2x"></span></div>
            <div class="col text-center my-auto">
                @if(!is_null($adjacent = $location->adjacent('east')))
                    <div>
                        <a href="{{ route('character.move', ['character' => Auth::user()->character, 'location' => $location->adjacent('east')]) }}">
                            {{ $location->adjacent('east')->name }}
                        </a>
                        <span class="fa fa-angle-right"></span>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col"></div>
            <div class="col text-center my-auto">
                @if(!is_null($adjacent = $location->adjacent('south')))
                    <span class="fa fa-angle-down"></span>
                    <div>
                        <a href="{{ route('character.move', ['character' => Auth::user()->character, 'location' => $location->adjacent('south')]) }}">
                            {{ $location->adjacent('south')->name }}
                        </a>
                    </div>
                @endif
            </div>
            <div class="col"></div>
        </div>

    </div>

</div>