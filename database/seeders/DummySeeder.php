<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 1; $i<=100; $i++) {
            User::create([
                'name' => 'admin',
                'email' => "admin$i@gmail.com",
                'password' => Hash::make('12345678')
            ]);
        }

    }
}
