@extends("base")

@section("head")
    <title>Inbox</title>
    @parent
@stop

@section("body")

    <div class="col-lg-10 offset-md-1 col-md-12 mt-3">
        <div>
            <!-- Nav tabs -->
            <ul class="nav nav-pills nav-fill" role="tablist">
                <li role="presentation" class="nav-item">
                    <a class="nav-link active" href="#inbox" aria-controls="inbox" role="tab">Inbox</a>
                </li>
                <li role="presentation" class="nav-item">
                    <a  class="nav-link" href="{{ URL::route('message.sent') }}" aria-controls="sent" role="tab">Sent</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active column" id="inbox">
                    @forelse ($receivedMessages as $message)
                        @include('message.partials.others-message-link', compact('message'))
                    @empty
                        @include('message.partials.no-messages')
                    @endforelse
                    {{ $receivedMessages->links() }}
                </div>
                <div role="tabpanel" class="tab-pane" id="sent">
                </div>
            </div>

        </div>
    </div>

@stop