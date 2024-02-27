<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run () : void {
        User::create([
            'name' => 'User test',
            'username' => 'user_test',
            'password' => Hash::make('password')
        ]);

        User::factory()->count(50)->create();
    }
}