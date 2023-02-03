<?php

namespace Database\Seeders;

use App\Models\Token;
use App\Models\User;
use Faker\Factory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \Dirape\Token\Token as TokenGenerator;

class TokensTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach ($users as $user) {
            $faker = Factory::create();
            $faker->name();
            $token = new TokenGenerator();
            $result = new Token([
                'user_id' => $user->id,
                'token' => $token->unique('tokens', 'token', 180, false),
                'expire_at' => null,
            ]);
            $result->save();
        }
    }
}