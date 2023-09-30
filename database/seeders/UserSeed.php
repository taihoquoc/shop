<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(
            [
                'id' => 1,
                'name' => 'master',
                'email' => 'master@mail.com',
                'password' => Hash::make('password')
            ]
        );
        User::firstOrCreate(
            [
                'id' => 2,
                'name' => 'test',
                'email' => 'test@mail.com',
                'password' => Hash::make('password')
            ]
        );
    }
}
