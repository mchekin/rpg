<nav class="navbar navbar-light bg-light navbar-expand-md">
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#myNavbar">&#x2630;
    </button>
    <a class="navbar-brand" href="{{ URL::route('home') }}">{{ config('app.name') }}</a>


    <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
            @if (Auth::check() && Auth::user()->hasCharacter())
                <li class="nav-item button">
                    <a href="{{ route('character.show', ['character' => Auth::user()->character]) }}" class="nav-link">
                        <span class="fa fa-user-circle" aria-hidden="true">
                            Character
                        </span>
                    </a>
                </li>
                <li class="nav-item button">
                    <a href="{{ route('location.show', ['location' => Auth::user()->character->location]) }}" class="nav-link">
                        <span class="fa fa-university" aria-hidden="true">
                            Location
                        </span>
                    </a>
                </li>
                <li class="nav-item button">
                    <a href="{{ URL::route('message.index') }}" class="nav-link">
                        <span class="fa fa-envelope">
                            Messages
                            @if(Auth::user()->character->receivedMessages()->unread()->count() > 0)
                                <span class="badge badge-danger">
                                     {{ Auth::user()->character->receivedMessages()->unread()->count() }}
                                </span>
                            @endif
                        </span>
                    </a>
                </li>
                <li class="nav-item button">
                    <a href="{{ URL::route('character.battle.index', ['character' => Auth::user()->character]) }}" class="nav-link">
                        <span class="fas fa-bolt">
                            Battles
                            @if(Auth::user()->character->defends()->unseenByDefender()->count() > 0)
                                <span class="badge badge-danger">
                                     {{ Auth::user()->character->defends()->unseenByDefender()->count() }}
                                </span>
                            @endif
                        </span>
                    </a>
                </li>
                @if (Auth::user()->hasPermission('browse_admin'))
                    <li class="nav-item button">
                        <a href="{{ URL::route('voyager.dashboard') }}" class="nav-link">
                        <span class="fas fa-tachometer-alt">
                            Admin
                        </span>
                        </a>
                    </li>
                @endif
            @endif
        </ul>
        <ul class="nav navbar-nav ml-auto">
            @if (Auth::check())
                @if (Auth::user()->hasCharacter() && Auth::user()->character->hasProfilePicture())
                    <li class="nav-item nav-avatar d-flex">
                        <a class="align-self-baseline" href="{{ route('character.show', ['character' => Auth::user()->character]) }}">
                            <img class="profile-picture-nav"
                                 src="{{ asset(Auth::user()->character->getProfilePictureSmall()) }}"
                                 alt="Avatar">
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <form role="form" method="POST" action="{{ route('logout') }}">
                            {{ csrf_field() }}
                            <button type="submit"><span class="glyphicon glyphicon-log-out"></span> Logout</button>
                        </form>
                    </a>
                </li>
            @else
                <li class="nav-item">
                    <a href="{{ URL::route('register') }}" class="nav-link">
                            <span class="glyphicon glyphicon-user">
                            </span> Register
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ URL::route('login') }}" class="nav-link">
                            <span class="glyphicon glyphicon-log-in">
                            </span> Login
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>
