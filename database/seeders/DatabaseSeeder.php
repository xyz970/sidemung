<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'nik' => '123456789',
            'name' => 'Muhammad Adi Saputro',
            'email'=>'muhammadxx7@gmail.com',
            'phone'=>'08123',
            'password'=>bcrypt('123')
        ]);
    }
}
