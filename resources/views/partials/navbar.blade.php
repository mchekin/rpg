<nav class="navbar navbar-light bg-light navbar-expand-md">
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#myNavbar">&#x2630;
    </button>
    <a class="navbar-brand" href="{{ URL::to('/') }}">{{ env('APP_NAME') }}</a>


    <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
            @if (Auth::check() && Auth::user()->hasCharacter())
                <li class="nav-item button">
                    <a href="{{ URL::route('message.inbox') }}" class="nav-link">
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
            @endif
        </ul>
        <ul class="nav navbar-nav ml-auto">
            @if (Auth::check())
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
                    <a href="{{ URL::to('register') }}" class="nav-link">
                            <span class="glyphicon glyphicon-user">
                            </span> Register
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ URL::to('login') }}" class="nav-link">
                            <span class="glyphicon glyphicon-log-in">
                            </span> Login
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>