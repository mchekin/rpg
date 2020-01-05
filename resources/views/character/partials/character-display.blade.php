@php
    /** @var \App\Modules\Character\Domain\Entities\Character $character */
    $hpPercent = ($character->getHitPoints() / $character->getTotalHitPoints()) * 100;
@endphp

<div class="progress mx-5 my-3">
    <div class="progress-bar bg-danger"
         role="progressbar"
         style="width: {{ $hpPercent }}%"
         aria-valuenow="{{ $hpPercent }}"
         aria-valuemin="0"
         aria-valuemax="100">
        {{ $character->getHitPoints() }} / {{ $character->getTotalHitPoints() }}
    </div>
</div>

<div class="profile-picture-wrapper row">
    <img class="profile-picture" src="{{ asset($character->getProfilePictureFull()) }}">
</div>

@if($character->isYou(Auth::id()))
    <div class="mx-5 my-3">
        <form role="form" method="POST"
              action="{{ route('character.profile-picture.store', ['character' => $character->getId()]) }}"
              enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" name="file" class="form-control form-control-sm" required>
                </div>
                <div class="mx-2 input-group-append">
                    <button type="submit" class="btn btn-success">
                        Upload <span class="fas fa-upload"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if($character->hasProfilePicture())
        <div class="text-center">
            @php
                /** @var \App\Modules\Character\Domain\Entities\Character $character */
                $profile_picture = $character->getProfilePicture();
            @endphp
            <form role="form" method="POST"
                  action="{{ route('character.profile-picture.destroy', compact('character', 'profile_picture')) }}">
                {{ method_field('DELETE') }}
                {!! csrf_field() !!}
                <div class="mx-2">
                    <button type="submit" class="btn btn-sm btn-danger">
                        Delete Profile Picture
                        <span class="fas fa-save"></span>
                    </button>
                </div>
            </form>
        </div>
    @endif
@endif

