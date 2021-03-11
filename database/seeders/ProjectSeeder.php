<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Project::create([
            'project_name' => 'Prvi projekt',
            'product_owner' => 1,
            'project_master' => 2
        ]);
        Project::create([
            'project_name' => 'Drugi projekt',
            'product_owner' => 2,
            'project_master' => 3
        ]);
        Project::create([
            'project_name' => 'Tretji projekt',
            'product_owner' => 3,
            'project_master' => 1
        ]);

        DB::table('project_user')->insert([
            ['project_id' => 1, 'user_id' => 1],
            ['project_id' => 1, 'user_id' => 2],
            ['project_id' => 1, 'user_id' => 3],
            ['project_id' => 2, 'user_id' => 1],
            ['project_id' => 2, 'user_id' => 2],
            ['project_id' => 2, 'user_id' => 3],
            ['project_id' => 3, 'user_id' => 1],
            ['project_id' => 3, 'user_id' => 2],
            ['project_id' => 3, 'user_id' => 3],
        ]);
    }
}
