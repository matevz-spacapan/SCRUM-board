<?php

namespace Database\Seeders;

use App\Models\Sprint;
use Illuminate\Database\Seeder;

class SprintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sprint::create([
            'project_id' => 1,
            'speed' => 1,
            'start_date' => '2021-04-01',
            'end_date' => '2021-04-10'
        ]);
        Sprint::create([
            'project_id' => 1,
            'speed' => 2,
            'start_date' => '2021-03-01',
            'end_date' => '2021-03-28'
        ]);
        Sprint::create([
            'project_id' => 2,
            'speed' => 2,
            'start_date' => '2021-04-13',
            'end_date' => '2021-04-23'
        ]);
    }
}
