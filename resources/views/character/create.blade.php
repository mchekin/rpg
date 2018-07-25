@extends("base")

@section("head")
    <title>Create Character</title>
    @parent
@stop

@section("body")
    <div class="row">

        <div class="col-lg-4 offset-lg-1 col-md-6 carousel carousel-race hidden-xsd-none d-sm-block" data-interval="false">
            <!-- Race Image slides -->
            <div class="carousel-inner" role="listbox">
                @foreach($races as $i => $race)
                <div class="carousel-item{{ ($i == 0) ? ' active' : '' }}">
                    <img class="img-race img-male" src="{{ asset('images/'.$race->male_image) }}">
                    <img class="img-race img-female" src="{{ asset('images/'.$race->female_image) }}" style="display: none;">
                    <div class="carousel-caption text-dark">
                        <h3>{{ $race->name }}</h3>
                        <p>{{ $race->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-lg-4 offset-lg-1 col-md-6">
            <form role="form" method="POST" action="{{ URL::route('character.store') }}">
                {!! csrf_field() !!}
                <input type="hidden" name="race_id" id="race_id" value="{{ $races[0]->id }}">
                <input type="hidden" name="gender" id="gender" value="male">

                <h3 class="text-center">Create game character</h3>
                <div class="form-group">
                    <div>
                        <label for="name" class="sr-only">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Name" required="" autofocus="">
                    </div>
                </div>

                <div class="form-group carousel carousel-race" id="race-carousel" data-interval="false">

                    <!-- Race Name slides -->
                    <div class="carousel-inner text-center" role="listbox">
                        @foreach($races as $i => $race)

                        <div class="carousel-item{{ ($i == 0) ? ' active' : '' }}" id="race-id-{{ $race->id }}">
                                <h3>{{ $race->name }}</h3>
                        </div>

                        @endforeach
                    </div>

                    <!-- Left and right controls -->
                    <a class="left-race carousel-control-prev text-dark" href="#race-carousel" role="button">
                        <span class="fa fa-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right-race carousel-control-next text-dark" href="#race-carousel" role="button">
                        <span class="fa fa-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>

                </div>
                <div class="form-group carousel carousel-gender" id="gender-carousel" data-interval="false">
                    <!-- Gender slides -->
                    <div class="carousel-inner text-center" role="listbox">

                        <div class="carousel-item active" id="male">
                            <h3>Male</h3>
                        </div>

                        <div class="carousel-item" id="female">
                            <h3>Female</h3>
                        </div>

                    </div>

                    <a class="left-gender carousel-control-prev text-dark" href="#gender-carousel" role="button">
                        <span class="fa fa-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>

                    <a class="right-gender carousel-control-next text-dark" href="#gender-carousel" role="button">
                        <span class="fa fa-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>

                </div>
                <div class="form-group carousel carousel-race" id="race-carousel" data-interval="false">
                    <!-- Race Stats slides -->
                    <div class="carousel-inner" role="listbox">
                        @foreach($races as $i => $race)
                        <div class="carousel-item{{ ($i == 0) ? ' active' : '' }} table-responsive table-attributes">
                            <table class="table">
                                <tr>
                                    <th>Strength</th>
                                    <td>{{ $race->strength }}</td>
                                </tr>
                                <tr>
                                    <th>Agility</th>
                                    <td>{{ $race->agility }}</td>
                                </tr>
                                <tr>
                                    <th>Constitution</th>
                                    <td>{{ $race->constitution }}</td>
                                </tr>
                                <tr>
                                    <th>Intelligence</th>
                                    <td>{{ $race->intelligence }}</td>
                                </tr>
                                <tr>
                                    <th>Charisma</th>
                                    <td>{{ $race->charisma }}</td>
                                </tr>
                            </table>
                        </div>
                        @endforeach
                    </div>

                </div>

                <div>
                    <button type="submit" class="btn btn-success btn-block">Create Character</button>
                </div>
            </form>
        </div>

    </div>

@stop

@section("footer")
    @parent

    <script src="{{ asset('js/character-create.js') }}"></script>
@stop