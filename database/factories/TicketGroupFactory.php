<?php

namespace Database\Factories;

use App\Models\TicketGroup;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TicketGroupFactory extends Factory
{
    protected $model = TicketGroup::class;

    public function definition(): array
    {
        return [
            'group_code' =>(string) Str::uuid(),
            'group_name' => $this->faker->company,
            'quota' => $this->faker->numberBetween(1, 10),
        ];
    }
}
