<?php


namespace App\Modules\Battle\Infrastructure\Repositories;


use App\Modules\Battle\Domain\Contracts\BattleRepositoryInterface;
use App\Modules\Battle\Domain\Entities\Battle;
use App\Battle as BattleModel;
use App\BattleRound as BattleRoundModel;
use App\Modules\Battle\Domain\Entities\BattleRound;
use App\Modules\Battle\Domain\Entities\BattleTurn;

class BattleRepository implements BattleRepositoryInterface
{
    public function add(Battle $battle)
    {
        /** @var BattleModel $battleModel */
        $battleModel = BattleModel::query()->create([
            'id' => $battle->getId(),
            'location_id' => $battle->getLocationId(),
            'attacker_id' => $battle->getAttacker()->getId(),
            'defender_id' => $battle->getDefender()->getId(),
            'victor_id' => $battle->getVictor()->getId(),
            'victor_xp_gained' => $battle->getVictorXpGained(),
        ]);

        /** @var BattleRound $round */
        foreach ($battle->getRounds()->all() as $round) {

            /** @var BattleRoundModel $roundModel */
            $roundModel = $battleModel->rounds()->create([]);

            /** @var BattleTurn $turn */
            foreach ($round->getTurns()->all() as $turn) {
                $roundModel->turns()->create([
                    'damage' => $turn->getDamageDone() ?? 0,
                    'executor_id' => $turn->getOwner()->getId(),
                    'target_id' => $turn->getTarget()->getId(),
                ]);
            }
        }

        $battle->setModel($battleModel);
    }
}