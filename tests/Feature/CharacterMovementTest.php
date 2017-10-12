<?php

namespace Tests\Feature;

use App\Character;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CharacterMovementTest extends TestCase
{
    use DatabaseMigrations;
}
