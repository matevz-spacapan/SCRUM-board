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
            'speed' => 15,
            'start_date' => '2021-04-01',
            'end_date' => '2021-06-10'
        ]);
        Sprint::create([
            'project_id' => 1,
            'speed' => 20,
            'start_date' => '2021-03-01',
            'end_date' => '2021-03-28'
        ]);
        Sprint::create([
            'project_id' => 3,
            'speed' => 30,
            'start_date' => '2021-05-01',
            'end_date' => '2021-05-28'
        ]);
        Sprint::create([
            'project_id' => 1,
            'speed' => 10,
            'start_date' => '2021-02-01',
            'end_date' => '2021-02-20'
        ]);
        Sprint::create([
            'project_id' => 2,
            'speed' => 14,
            'start_date' => '2021-04-13',
            'end_date' => '2021-04-23'
        ]);
    }
}
