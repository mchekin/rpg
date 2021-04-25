<?php


namespace App\Modules\Battle\Infrastructure\Repositories;


use App\Modules\Battle\Application\Contracts\BattleRepositoryInterface;
use App\Modules\Battle\Domain\Battle;
use App\Models\Battle as BattleModel;
use App\Models\BattleRound as BattleRoundModel;
use App\Modules\Battle\Domain\BattleId;
use App\Modules\Battle\Domain\BattleRound;
use App\Modules\Battle\Domain\BattleTurn;
use App\Traits\GeneratesUuid;
use Exception;

class BattleRepository implements BattleRepositoryInterface
{
    use GeneratesUuid;

    /**
     * @return BattleId
     *
     * @throws Exception
     */
    public function nextIdentity(): BattleId
    {
        return BattleId::fromString($this->generateUuid());
    }

    public function add(Battle $battle): void
    {
        /** @var BattleModel $battleModel */
        $battleModel = BattleModel::query()->create([
            'id' => $battle->getId()->toString(),
            'location_id' => $battle->getLocationId(),
            'attacker_id' => $battle->getAttacker()->getId()->toString(),
            'defender_id' => $battle->getDefender()->getId()->toString(),
            'victor_id' => $battle->getVictor()->getId()->toString(),
            'victor_xp_gained' => $battle->getVictorXpGained(),
        ]);

        /** @var BattleRound $round */
        foreach ($battle->getRounds()->all() as $round) {

            /** @var BattleRoundModel $roundModel */
            $roundModel = $battleModel->rounds()->create([
                'id' => $round->getId(),
            ]);

            /** @var BattleTurn $turn */
            foreach ($round->getTurns()->all() as $turn) {
                $roundModel->turns()->create([
                    'id' => $turn->getId(),
                    'damageDone' => $turn->getDamageDone(),
                    'damageAbsorbed' => $turn->getDamageAbsorbed(),
                    'result_type' => $turn->getResultType(),
                    'executor_id' => $turn->getOwner()->getId()->toString(),
                    'target_id' => $turn->getTarget()->getId()->toString(),
                ]);
            }
        }
    }
}
