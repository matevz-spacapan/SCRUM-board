<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userAdmin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin')
        ]);
        $roleAdmin = Role::create(['name' => 'Administrator']);
        $permissionsAdmin = Permission::pluck('id','id')->all();
        $roleAdmin->syncPermissions($permissionsAdmin);
        $userAdmin->assignRole([$roleAdmin->id]);

        $userDev = User::create([
            'name' => 'Developer',
            'email' => 'devel@devel.com',
            'password' => bcrypt('devel')
        ]);
        $roleDev = Role::create(['name' => 'User']);
        $roleDev->syncPermissions();
        $userDev->assignRole([$roleDev->id]);

        $userCust = User::create([
            'name' => 'Customer',
            'email' => 'cust@cust.com',
            'password' => bcrypt('cust')
        ]);
        $userCust->assignRole([$roleDev->id]);
    }
}
