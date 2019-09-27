<?php
    /** @var \App\Character $character */
    $hpPercent = ($character->getHitPoints() / $character->getTotalHitPoints()) * 100;
?>

<h2 class="text-center">
    {{ $character->getName() }}
</h2>

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

@if($character->isYou())
    <div class="mx-5 my-3">
        <form role="form" method="POST"
              action="{{ route('character.profile-picture.store', compact('character')) }}"
              enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" name="file" class="form-control" required>
                </div>
                <div class="mx-2 input-group-append">
                    <button type="submit" class="btn btn-success">Upload <span class="fas fa-upload"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if($character->hasProfilePicture())
        <div class="text-center">
            <?php
            /** @var \App\Character $character */
            $profilePicture = $character->getProfilePicture()
            ?>
            <form role="form" method="POST"
                  action="{{ route('character.profile-picture.destroy', compact('character', 'profilePicture')) }}">
                {{ method_field('DELETE') }}
                {!! csrf_field() !!}
                <div class="mx-2">
                    <button type="submit" class="btn btn-danger btn-sm">Delete Profile Picture <span
                                class="fas fa-save"></span></button>
                </div>
            </form>
        </div>
    @endif

@else
    <div class="w-100 my-3 px-5 text-center" role="group" aria-label="Character Actions">
        @if(!$character->isNPC())
            <a href="{{ route('character.message.index', ['character' => $character]) }}"
               class="btn btn-sm btn-success">
                message <span class="fa fa-comment"></span>
            </a>
        @endif

        <a href="{{ route('character.attack', ['character' => $character]) }}"
           class="btn btn-sm btn-danger">
            attack <span class="fas fa-bolt"></span>
        </a>
    </div>
@endif

<div class="text-center my-5">
    <a class="btn btn-primary" href="{{ route('location.show', ['location' => $character->getLocationId()]) }}">
        To {{ $character->getLocationName() }}
        <span class="fas fa-walking"></span>
    </a>
</div>

