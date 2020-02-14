<table class="table">
    <caption class="caption-top">General</caption>
    <tr>
        <th scope="row">Race</th>
        <td>{{ $character->getRaceName() }}</td>
    </tr>
    <tr>
        <th scope="row">Gender</th>
        <td>{{ $character->gender }}</td>
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
                     style="width: {{ $level->getProgress($character->xp) }}%"
                     aria-valuenow="{{ $level->getProgress($character->xp) }}"
                     aria-valuemin="0"
                     aria-valuemax="100">
                    {{ $character->xp }} / {{ $level->getNextXpThreshold() }}
                </div>
            </div>
        </td>
    </tr>
</table>
