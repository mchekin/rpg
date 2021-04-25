<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        if (User::query()->count())
        {
            return;
        }

        $users = [
            [
                'name' => 'Misha Chekin',
                'password' => Hash::make('1234'),
                'email' => 'mchekin@gmail.com',
                'api_token' => Str::random(60),
            ],
        ];

        foreach ($users as $user) {
            User::query()->create($user);
        }
    }
}
