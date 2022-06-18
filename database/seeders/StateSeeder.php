<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = State::insert([
            ['name' => 'Alberta '],
            ['name' => 'British Columbia'],
            ['name' => 'Manitoba'],
            ['name' => 'New Brunswick'],
            ['name' => 'Newfoundland and Labrador'],
            ['name' => 'Northwest Territories'],
            ['name' => 'Nova Scotia'],
            ['name' => 'Nunavut'],
            ['name' => 'Ontario']
        ]);
      
    }
}
