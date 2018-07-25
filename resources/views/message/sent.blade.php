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
                    <a class="nav-link" href="{{ URL::route('message.inbox') }}" aria-controls="inbox" role="tab">Inbox</a>
                </li>
                <li role="presentation" class="nav-item">
                    <a class="nav-link active" href="#sent" aria-controls="sent" role="tab">Sent</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane" id="inbox"></div>
                <div role="tabpanel" class="tab-pane active column" id="sent">
                    @forelse ($sentMessages as $message)
                        @include('message.partials.my-message-link', compact('message'))
                    @empty
                        @include('message.partials.no-messages')
                    @endforelse
                    {{ $sentMessages->links() }}
                </div>
            </div>
        </div>
    </div>

@stop