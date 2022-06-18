<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = City::insert([
            ['name' => 'Airdrie','state_id' => 1],
            ['name' => 'Athabasca','state_id' => 1],
            ['name' => 'Banff','state_id' => 1],
            ['name' => 'Barrhead','state_id' => 1],
            ['name' => 'Bassano','state_id' => 1],
            ['name' => 'Abbotsford','state_id' => 2],
            ['name' => 'Agassiz','state_id' => 2],
            ['name' => 'Aldergrove','state_id' => 2],
            ['name' => 'Aldergrove East','state_id' => 2],
            ['name' => 'Altona','state_id' => 3],
            ['name' => 'Beausejour','state_id' => 3],
            ['name' => 'Bathurst','state_id' => 4],
            ['name' => 'Bouctouche','state_id' => 4],
            ['name' => 'Campbellton','state_id' => 4],
            ['name' => 'Bay Roberts','state_id' => 5],
        ]);
    }
}
