<div class="message-list-container row">
    <div class="col-sm-2 text-center">
        <div class="clearfix">
            <img src="https://vignette.wikia.nocookie.net/forgottenrealms/images/f/fa/Jon_Irenicus.jpg" alt="Avatar">
        </div>
        <div>{{ $message->created_at }}</div>
    </div>
    <div class="col-sm-10">
        <p>{!! $message->content !!}</p>
    </div>
</div>