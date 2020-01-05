<?php
/** @var \App\Modules\Character\Domain\Entities\Character $character */

$hasFreePoints = ($character->isYou(Auth::id()) && $character->getUnassignedAttributePoints());
?>

@if($hasFreePoints)
    <form role="form" method="POST" action="{{ route('character.update', $character) }}"
          id="increment_attribute">
        {{ method_field('PUT') }}
        {!! csrf_field() !!}

        <input type="hidden" id="attribute_input" name="attribute" value="strength">
        @endif

        <table class="table">
            <caption class="caption-top">Attributes</caption>
            <tr>
                <th scope="row">Strength</th>
                <td>{{ $character->getStrength() }}</td>
                @component('components.increment_attribute_button', compact('hasFreePoints'))
                    {{ 'strength' }}
                @endcomponent
            </tr>
            <tr>
                <th scope="row">Agility</th>
                <td>{{ $character->getAgility() }}</td>
                @component('components.increment_attribute_button', compact('hasFreePoints'))
                    {{ 'agility' }}
                @endcomponent
            </tr>
            <tr>
                <th scope="row">Constitution</th>
                <td>{{ $character->getConstitution() }}</td>
                @component('components.increment_attribute_button', compact('hasFreePoints'))
                    {{ 'constitution' }}
                @endcomponent
            </tr>
            <tr>
                <th scope="row">Intelligence</th>
                <td>{{ $character->getIntelligence() }}</td>
                @component('components.increment_attribute_button', compact('hasFreePoints'))
                    {{ 'intelligence' }}
                @endcomponent
            </tr>
            <tr>
                <th scope="row">Charisma</th>
                <td>{{ $character->getCharisma() }}</td>
                @component('components.increment_attribute_button', compact('hasFreePoints'))
                    {{ 'charisma' }}
                @endcomponent
            </tr>

            @if($hasFreePoints)
                <tfoot>
                <tr>
                    <th scope="row">Available points</th>
                    <td class="circle">{{ $character->getUnassignedAttributePoints() }}</td>
                </tr>
                </tfoot>
            @endif

        </table>

        @if($hasFreePoints)
    </form>
@endif
