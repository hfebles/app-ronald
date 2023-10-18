<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => '1@1.com',
            'password' => bcrypt('123')
        ]);

        $user = User::create([
            'name' => 'Ronald Rubio',
            'email' => 'ronal@instruelect.com',
            'password' => bcrypt('12345678')
        ]);
    }
}
