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
            'username' => 'Administrator',
            'name' => 'Site',
            'surname' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin')
        ]);
        $roleAdmin = Role::create(['name' => 'Administrator']);
        $permissionsAdmin = Permission::pluck('id','id')->all();
        $roleAdmin->syncPermissions($permissionsAdmin);
        $userAdmin->assignRole([$roleAdmin->id]);

        $userDev = User::create([
            'username' => 'matjaz',
            'name' => 'Matjaž',
            'surname' => 'Rupnik',
            'email' => 'matjaz@none.com',
            'password' => bcrypt('mrupnik')
        ]);
        $roleDev = Role::create(['name' => 'User']);
        $roleDev->syncPermissions();
        $userDev->assignRole([$roleDev->id]);

        $userCust = User::create([
            'username' => 'blaz',
            'name' => 'Blaž',
            'surname' => 'Ličen',
            'email' => 'blaz@none.com',
            'password' => bcrypt('blicen')
        ]);
        $userCust->assignRole([$roleDev->id]);

        $userCust = User::create([
            'username' => 'klemen',
            'name' => 'Klemen',
            'surname' => 'Kobau',
            'email' => 'klemen@none.com',
            'password' => bcrypt('kkobau')
        ]);
        $userCust->assignRole([$roleDev->id]);

        $userCust = User::create([
            'username' => 'matevz',
            'name' => 'Matevž',
            'surname' => 'Špacapan',
            'email' => 'matevz@none.com',
            'password' => bcrypt('mspacapan')
        ]);
        $userCust->assignRole([$roleDev->id]);
    }
}
