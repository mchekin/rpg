<?php
/** @var \App\Modules\Character\Domain\Entities\Character $character */

$hasFreePoints = ($character->isYou(Auth::id()) && $character->getUnassignedAttributePoints());
?>

<table class="table">
    <caption class="caption-top">Statistics</caption>
    <tr>
        <th scope="row">Reputation</th>
        <td>{{ $character->getReputation()->getValue() }}</td>
    </tr>
    <tr>
        <th scope="row">Money</th>
        <td>{{ $character->getMoney()->getValue() }}</td>
    </tr>
    <tr>
        <th scope="row">
            <a href="{{ route('character.battle.index', ['character' => $character->getId()]) }}">
                Battles Won
            </a>
        </th>
        <td>{{ $character->getBattlesWon() }}</td>
    </tr>
    <tr>
        <th scope="row">
            <a href="{{ route('character.battle.index', ['character' => $character->getId()]) }}">
                Battles Lost
            </a></th>
        <td>{{ $character->getBattlesLost() }}</td>
    </tr>
</table>
