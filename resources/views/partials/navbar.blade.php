<nav class="navbar navbar-default">
    <div class="container-fluid">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ URL::to('/') }}">{{ env('APP_NAME') }}</a>
        </div>

        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                @if (Auth::check())
                    <li class="nav-item button">
                        <a href="{{ URL::route('message.inbox') }}" class="nav-link">
                            <span class="fa fa-envelope">
                                Messages
                                @if(Auth::user()->receivedMessages()->unread()->count() > 0)
                                    <span class="label label-danger">
                                        {{ Auth::user()->receivedMessages()->unread()->count() }}
                                    </span>
                                @endif
                            </span>
                        </a>
                    </li>
                @endif
                {{--<li class="active"><a href="{{ URL::to('/home') }}">Home</a></li>--}}
            </ul>
            <ul class="nav navbar-nav navbar-right">
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
                    <li><a href="{{ URL::to('register') }}"><span class="glyphicon glyphicon-user"></span> Register</a></li>
                    <li><a href="{{ URL::to('login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                @endif
            </ul>
        </div>

    </div>
</nav>