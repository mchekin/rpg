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

                <li role="presentation">
                    <a href="{{ URL::route('message.inbox') }}" aria-controls="inbox" role="tab">
                        Inbox
                    </a>
                </li>

                <li role="presentation" class="active">
                    <a href="#sent" aria-controls="sent" role="tab">
                        Sent
                    </a>
                </li>

            </ul>

            <!-- Tab panes -->
            <div class="tab-content">

                <div role="tabpanel" class="tab-pane" id="inbox">


                </div>

                <div role="tabpanel" class="tab-pane active" id="sent">

                    <div class="row">
                        @foreach ($sentMessages as $message)
                            @include('message.partials.my-message-link', compact('message'))
                        @endforeach
                        {{ $sentMessages->links() }}
                    </div>

                </div>

            </div>

        </div>

    </div>

@stop