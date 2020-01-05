<?php
    /** @var \App\Modules\Character\Domain\Entities\Character $character */
    /** @var \App\Modules\Level\Domain\Entities\Level $level */
    $levelProgress = $level->getProgress($character->getXp());
?>
<table class="table">
    <caption class="caption-top">General</caption>
    <tr>
        <th scope="row">Race</th>
        <td>{{ $character->getRace()->getName() }}</td>
    </tr>
    <tr>
        <th scope="row">Gender</th>
        <td>{{ $character->getGender()->getValue() }}</td>
    </tr>
    <tr>
        <th scope="row">Level</th>
        <td>{{ $level->getId() }}</td>
    </tr>
    <tr>
        <th scope="row">XP</th>
        <td>
            <div class="progress">
                <div class="progress-bar"
                     role="progressbar"
                     style="width: {{ $levelProgress }}%"
                     aria-valuenow="{{ $levelProgress }}"
                     aria-valuemin="0"
                     aria-valuemax="100">
                    {{ $character->getXp() }} / {{ $level->getNextXpThreshold() }}
                </div>
            </div>
        </td>
    </tr>
</table>
