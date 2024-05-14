<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            [
                'username' => '1.1.2.22.0.0.1.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'YOHANA WORAID',
                'nohp' => '-',
                'photo' => 'assets/profile/1.jpg',
                'idrole' => 'assets/profile/1.jpg',
            ],
        ]);
    }
}
