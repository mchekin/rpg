@extends("base")

@section("head")
    <title>Inbox</title>
    @parent
@stop

@section("body")

    <div class="col-md-10 col-md-offset-1 col-sm-12">

        <div>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">

                <li role="presentation" class="active">
                    <a href="#inbox" aria-controls="inbox" role="tab">
                        Inbox
                    </a>
                </li>

                <li role="presentation">
                    <a href="{{ URL::route('message.sent') }}" aria-controls="sent" role="tab">
                        Sent
                    </a>
                </li>

            </ul>

            <!-- Tab panes -->
            <div class="tab-content">

                <div role="tabpanel" class="tab-pane active" id="inbox">

                    <div class="row">
                        @foreach ($receivedMessages as $message)
                            @include('message.partials.others-message-link', compact('message'))
                        @endforeach
                        {{ $receivedMessages->links() }}
                    </div>

                </div>

                <div role="tabpanel" class="tab-pane" id="sent">

                </div>

            </div>

        </div>

    </div>

@stop