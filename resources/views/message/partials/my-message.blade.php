<div class="message-list-container row">
    <div class="col-md-2 text-center">
        <div class="clearfix">
            <img src="{{ asset('svg/avatar.svg') }}" alt="Avatar">
        </div>
        <div>{{ $message->created_at }}</div>
    </div>
    <div class="col-md-10">
        <p>{!! $message->content !!}</p>
    </div>
</div>