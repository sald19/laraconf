<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendee>
 */
final class AttendeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'ticket_cost' => 50000,
            'is_paid' => true,
            'created_at' => $this->faker->dateTimeBetween(startDate: '-3 months', endDate: 'now'),
            'conference_id' => 1,
        ];
    }
}
