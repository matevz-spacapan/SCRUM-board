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
            'title' => 'Prvi projekt',
        ]);
        DB::table('project_user')->insert([
            'project_id' => 1,
            'user_id' => 1,
            'role' => 1,
        ]);
        DB::table('project_user')->insert([
            'project_id' => 1,
            'user_id' => 2,
            'role' => 2,
        ]);
        DB::table('project_user')->insert([
            'project_id' => 1,
            'user_id' => 3,
            'role' => 3,
        ]);
        Project::create([
            'title' => 'Drugi projekt',
        ]);
        Project::create([
            'title' => 'Tretji projekt',
        ]);
    }
}
