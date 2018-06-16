<div class="message-list-container message-list-darker">
    <div class="col-sm-10">
        <p>{!! $message->content !!}</p>
    </div>
    <div class="col-sm-2 text-center">
        <div class="clearfix">
            <img src="https://vignette.wikia.nocookie.net/forgottenrealms/images/9/95/Sarevok_-_Throne_of_Bhaal.png" alt="Avatar" class="right">
        </div>
        <div>{{ $message->created_at }}</div>
    </div>
</div>