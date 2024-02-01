<?php

namespace Database\Seeders;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(100)->create();

        DB::table('users')->insert([
            'name' => 'Admin Admin',
            'username' => 'admin',  // Provide a value for the 'username' field
            'email' => 'admin@gmail.com',
            'phone' => 11111111,
            'role' => 'admin',
            'password' => Hash::make('123456'),
            'api_token'=>Str::random(60),
        ]);
    }
}
