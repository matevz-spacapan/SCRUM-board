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
            'project_name' => 'First project',
            'product_owner' => 1,
            'project_master' => 2
        ]);
        Project::create([
            'project_name' => 'Second project',
            'product_owner' => 3,
            'project_master' => 1
        ]);
        Project::create([
            'project_name' => 'Third project',
            'product_owner' => 2,
            'project_master' => 3
        ]);

        DB::table('project_user')->insert([
            ['project_id' => 1, 'user_id' => 1],
            ['project_id' => 1, 'user_id' => 3],
            ['project_id' => 2, 'user_id' => 1],
            ['project_id' => 2, 'user_id' => 2],
            ['project_id' => 3, 'user_id' => 1],
            ['project_id' => 3, 'user_id' => 2],
            ['project_id' => 3, 'user_id' => 3],
        ]);
    }
}
