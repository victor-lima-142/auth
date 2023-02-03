<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 38; $i++) {
            $faker = Factory::create();
            $faker->name();
            $user = new User([
                'username' => $faker->userName(),
                'email' => $faker->email(),
                'password' => Hash::make('@Tu40028922'),
                'level' => $faker->numberBetween(1, 5)
            ]);
            $user->save();
        }
    }
}
