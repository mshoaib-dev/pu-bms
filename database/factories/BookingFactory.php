<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'start_date'=>fake()->unique()->dateTimeBetween('now', '+1 week')->format('Y-m-d'),
            'end_date'=>fake()->unique()->dateTimeBetween('+1 week', '+2 weeks')->format('Y-m-d'),
            'phone_no'=>fake()->phoneNumber(),
            'departure_address'=>fake()->address(),
            'destination_address'=>fake()->address(),
            'cnic'=>fake()->phoneNumber(),
        ];
    }
}
