<table class="table">
    <caption class="caption-top">Statistics</caption>
    <tr>
        <th scope="row">Reputation</th>
        <td>{{ $character->reputation }}</td>
    </tr>
    <tr>
        <th scope="row">Money</th>
        <td>{{ $character->inventory->money }}</td>
    </tr>
    <tr>
        <th scope="row">
            <a href="{{ route('character.battle.index', compact('character')) }}">
                Battles Won
            </a>
        </th>
        <td>{{ $character->battles_won }}</td>
    </tr>
    <tr>
        <th scope="row">
            <a href="{{ route('character.battle.index', compact('character')) }}">
                Battles Lost
            </a></th>
        <td>{{ $character->battles_lost }}</td>
    </tr>
</table>
