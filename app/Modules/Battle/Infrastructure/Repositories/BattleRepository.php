<?php


namespace App\Modules\Battle\Infrastructure\Repositories;


use App\Modules\Battle\Application\Contracts\BattleRepositoryInterface;
use App\Modules\Battle\Domain\Battle;
use App\Battle as BattleModel;
use App\BattleRound as BattleRoundModel;
use App\Modules\Battle\Domain\BattleId;
use App\Modules\Battle\Domain\BattleRound;
use App\Modules\Battle\Domain\BattleTurn;
use Exception;
use Ramsey\Uuid\Uuid;

class BattleRepository implements BattleRepositoryInterface
{
    /**
     * @return BattleId
     *
     * @throws Exception
     */
    public function nextIdentity(): BattleId
    {
        return BattleId::fromString(Uuid::uuid4()->toString());
    }

    public function add(Battle $battle): void
    {
        /** @var BattleModel $battleModel */
        $battleModel = BattleModel::query()->create([
            'id' => $battle->getId()->toString(),
            'location_id' => $battle->getLocationId(),
            'attacker_id' => $battle->getAttacker()->getId(),
            'defender_id' => $battle->getDefender()->getId(),
            'victor_id' => $battle->getVictor()->getId(),
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
                    'executor_id' => $turn->getOwner()->getId(),
                    'target_id' => $turn->getTarget()->getId(),
                ]);
            }
        }
    }
}
