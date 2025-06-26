<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            User::create([
            'name' => 'Admin Event',
            'divisi' => 'inti',
            'email' => 'admin@event.test',
            'password' => Hash::make('password123'), // Gunakan hash untuk keamanan
        ]);

        // Tambahan user opsional
        User::create([
            'name' => 'Staff Guest Star',
            'divisi' => 'inti',
            'email' => 'gueststaff@event.test',
            'password' => Hash::make('password123'),
        ]);
    }
}
