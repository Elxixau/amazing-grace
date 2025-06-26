<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TicketQuote;

class TicketQuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $groups = [
            ['group_name' => 'A', 'total_seats' => 500],
            ['group_name' => 'B', 'total_seats' => 500],
            ['group_name' => 'C', 'total_seats' => 500],
            ['group_name' => 'D', 'total_seats' => 500],
            ['group_name' => 'E', 'total_seats' => 500],
            ['group_name' => 'F', 'total_seats' => 200], // Total 2700
        ];

        foreach ($groups as $group) {
            TicketQuote::create([
                'group_name' => $group['group_name'],
                'total_seats' => $group['total_seats'],
                'available_seats' => $group['total_seats'],
            ]);
        }
    }
}
