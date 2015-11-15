@extends("base")

@section("head")
    <title>Create Character</title>
    @parent
@stop

@section("body")
    <div class="row">
        <div  id="myCarousel" class="col-md-4 col-md-offset-1 carousel slide" data-interval="false">
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img class="img-race" src="{{ asset('images/human-male.png') }}">
                    <div class="carousel-caption">
                        <h3>Human</h3>
                        <p>This race combines in itself all the properties of the other races, albeit they are less pronounced.</p>
                    </div>
                </div>
                <div class="item">
                    <img class="img-race" src="{{ asset('images/elf-female.png') }}">
                    <div class="carousel-caption">
                        <h3>Elf</h3>
                        <p>This race is known for it's great agility, but lacks constitution.</p>
                    </div>
                </div>

                <div class="item">
                    <img class="img-race" src="{{ asset('images/dwarf-male.png') }}">
                    <div class="carousel-caption">
                        <h3>Dwarf</h3>
                        <p>This race is known for it's constitution and resilience, but lack agility and grace.</p>
                    </div>
                </div>

                <div class="item">
                    <img class="img-race" src="{{ asset('images/orc-male.png') }}">
                    <div class="carousel-caption">
                        <h3>Orc</h3>
                        <p>This race enjoys great physical strength, but lacks intelligence.</p>
                    </div>
                </div>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div class="col-md-4 col-md-offset-1">
            <form role="form" method="POST" action="{{ URL::route('character.store') }}">
                {!! csrf_field() !!}
                <h2>Please create your game character</h2>
                <div class="form-group">
                    <div>
                        <label for="name" class="sr-only">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Name" required="" autofocus="">
                    </div>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary btn-block">Create</button>
                </div>
            </form>
        </div>
    </div>

@stop