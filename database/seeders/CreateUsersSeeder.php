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
        $roleAdmin = Role::create(['name' => 'Admin']);
        $permissionsAdmin = Permission::pluck('id','id')->all();
        $roleAdmin->syncPermissions($permissionsAdmin);
        $userAdmin->assignRole([$roleAdmin->id]);
        
        $userDev = User::create([
            'name' => 'Developer',
            'email' => 'devel@devel.com',
            'password' => bcrypt('devel')
        ]);
        $roleDev = Role::create(['name' => 'Developer']);
        $permissionsDev = array( 9 => 9, 13 => 13, 17 => 17, 18 => 18, 19 => 19, 20 => 20);
        $roleDev->syncPermissions($permissionsDev);
        $userDev->assignRole([$roleDev->id]);
        
        $userCust = User::create([
            'name' => 'Customer',
            'email' => 'cust@cust.com',
            'password' => bcrypt('cust')
        ]);
        $roleCust = Role::create(['name' => 'Customer']);
        $permissionsCust = array( 13 => 13, 14 => 14, 15 => 15, 16 => 16);
        $roleCust->syncPermissions($permissionsCust);
        $userCust->assignRole([$roleCust->id]);
    }
}