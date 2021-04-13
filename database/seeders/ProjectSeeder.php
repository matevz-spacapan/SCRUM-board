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
            'project_name' => 'Gugl Map',
            'product_owner' => 2,
            'project_master' => 3,
            'documentation' => '# My awesome header for Gugl Map

This text is *italic* but this one is **bold**, you can also add a [Link](http://www.example.com).'
        ]);
        Project::create([
            'project_name' => 'Web crawler',
            'product_owner' => 3,
            'project_master' => 4,
            'documentation' => '# My awesome header for Web crawler

This text is *italic* but this one is **bold**, you can also add a [Link](http://www.example.com).'
        ]);
        Project::create([
            'project_name' => 'OKulus Index',
            'product_owner' => 5,
            'project_master' => 2,
            'documentation' => '# My awesome header for OKulus Index

This text is *italic* but this one is **bold**, you can also add a [Link](http://www.example.com).'
        ]);

        DB::table('project_user')->insert([
            ['project_id' => 1, 'user_id' => 3],
            ['project_id' => 1, 'user_id' => 4],
            ['project_id' => 1, 'user_id' => 5],
            ['project_id' => 2, 'user_id' => 4],
            ['project_id' => 2, 'user_id' => 2],
            ['project_id' => 3, 'user_id' => 2],
            ['project_id' => 3, 'user_id' => 4],
        ]);
    }
}
