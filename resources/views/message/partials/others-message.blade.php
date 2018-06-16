<div class="message-list-container message-list-darker">
    <div class="col-sm-10">
        <p>{!! $message->content !!}</p>
    </div>
    <div class="col-sm-2 text-center">
        <div class="clearfix">
            <img src="{{ asset('svg/avatar.svg') }}" alt="Avatar">
        </div>
        <div>{{ $message->created_at }}</div>
    </div>
</div>