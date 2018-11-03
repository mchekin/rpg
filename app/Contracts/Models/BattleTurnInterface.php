<?php

namespace App\Contracts\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface BattleTurnInterface
{
    /**
     * @return BelongsTo
     */
    public function executor();

    /**
     * @return BelongsTo
     */
    public function target();
}