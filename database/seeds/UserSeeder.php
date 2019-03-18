<?php

use App\User;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $users = [
            [
                "id"            => Uuid::uuid4(),
                "name"          => "Misha Chekin",
                "password"      => Hash::make("1234"),
                "email"         => "mchekin@gmail.com",
            ],
        ];

        foreach ($users as $user)
        {
           User::query()->create($user);
        }
    }
}
