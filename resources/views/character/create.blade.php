@extends("base")

@section("head")
    <title>Create Character</title>
    @parent
@stop

@section("body")
    <div class="row">
        <div class="col-md-4 col-md-offset-1 col-sm-6 carousel carousel-race hidden-xs" data-interval="false">
            <!-- Race Image slides -->
            <div class="carousel-inner" role="listbox">
                @foreach($races as $i => $race)
                <div class="item{{ ($i == 0) ? ' active' : '' }}">
                    <img class="img-race img-male" src="{{ asset('images/'.$race->male_image) }}">
                    <img class="img-race img-female" src="{{ asset('images/'.$race->female_image) }}" style="display: none;">
                    <div class="carousel-caption">
                        <h3>{{ $race->name }}</h3>
                        <p>{{ $race->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-4 col-md-offset-1 col-sm-6">
            <form role="form" method="POST" action="{{ URL::route('character.store') }}">
                {!! csrf_field() !!}
                <h2>Please create your game character</h2>
                <div class="form-group">
                    <div>
                        <label for="name" class="sr-only">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Name" required="" autofocus="">
                    </div>
                </div>
                <div class="form-group carousel carousel-race" id="character-carousel" data-interval="false">
                    <!-- Race Name slides -->
                    <div class="carousel-inner" role="listbox">
                        @foreach($races as $i => $race)
                        <div class="item{{ ($i == 0) ? ' active' : '' }}">
                            <div class="carousel-content">
                                <h3>{{ $race->name }}</h3>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Left and right controls -->
                    <a class="left left-race carousel-control" href="#character-carousel" role="button">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>

                    <a class="right right-race carousel-control" href="#character-carousel" role="button">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>

                </div>
                <div class="form-group carousel carousel-gender" id="gender-carousel" data-interval="false">
                    <!-- Gender slides -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item active" id="male">
                            <div class="carousel-content">
                                <h3>Male</h3>
                            </div>
                        </div>
                        <div class="item" id="female">
                            <div class="carousel-content">
                                <h3>Female</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Left and right controls -->
                    <a class="left left-gender carousel-control" href="#gender-carousel" role="button">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>

                    <a class="right right-gender carousel-control" href="#gender-carousel" role="button">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>

                </div>
                {{--<div class="row form-group">--}}
                    {{--<button type="button" class="btn btn-primary col-xs-3 col-xs-offset-2 btn-gender active">--}}
                        {{--<span class="fa fa-mars fa-4x"></span>--}}
                    {{--</button>--}}
                    {{--<button type="button" class="btn btn-primary col-xs-3 col-xs-offset-2 btn-gender">--}}
                        {{--<span class="fa fa-venus fa-4x"></span>--}}
                    {{--</button>--}}
                {{--</div>--}}
                <div class="form-group carousel carousel-race" id="character-carousel" data-interval="false">
                    <!-- Race Stats slides -->
                    <div class="carousel-inner" role="listbox">
                        @foreach($races as $i => $race)
                        <div class="item{{ ($i == 0) ? ' active' : '' }} carousel-content table-responsive table-attributes">
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