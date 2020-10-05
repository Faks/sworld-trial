<?php

declare(strict_types=1);

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()
            ->create(
                [
                    'name' => 'Sworld Trial',
                    'email' => 'sworld-trial@solum-designum.eu',
                    'password' => Hash::make('sworld-trial'),
                    'api_token' => Str::random(60),
                ]
            );
    }
}
