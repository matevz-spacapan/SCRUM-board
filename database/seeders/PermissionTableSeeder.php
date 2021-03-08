<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
  
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
           
           'users-list',
           'users-create',
           'users-edit',
           'users-delete',
           
           'project-list',
           'project-create',
           'project-edit',
           'project-delete',
           
           'story-list',
           'story-create',
           'story-edit',
           'story-delete',
           
           'task-list',
           'task-create',
           'task-edit',
           'task-delete',
        ];
     
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}