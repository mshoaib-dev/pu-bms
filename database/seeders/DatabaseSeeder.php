<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run()

    {
//        $this->call(BookingSeeder::class);
//        $this->call(VehicleSeeder::class);

        \App\Models\User::create([
             'full_name' => 'Danish Arif',
             'email' => 'danisharif@pu.edu.pk',
             'password' => Hash::make('danish123'),
             'type' => 'Admin',
         ]);
    }
}
