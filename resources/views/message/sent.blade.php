@extends("base")

@section("head")
    <title>Inbox</title>
    @parent
@stop

@section("body")
    <div class="col-lg-10 offset-md-1 col-md-12">
        <div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="nav-item">
                    <a href="{{ URL::route('message.inbox') }}" aria-controls="inbox" role="tab"
                       class="nav-link">
                        Inbox
                    </a>
                </li>
                <li role="presentation" class="active nav-item">
                    <a href="#sent" aria-controls="sent" role="tab" class="nav-link">
                        Sent
                    </a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane" id="inbox"></div>
                <div role="tabpanel" class="tab-pane active column" id="sent">
                    @foreach ($sentMessages as $message)
                        @include('message.partials.my-message-link', compact('message'))
                    @endforeach
                    {{ $sentMessages->links() }}
                </div>
            </div>
        </div>
    </div>

@stop