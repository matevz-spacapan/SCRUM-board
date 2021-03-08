<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
  
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $roleDev = Role::create(['name' => 'Developer']);
        $permissionsDev = array( 9 => 9, 13 => 13, 17 => 17, 18 => 18, 19 => 19, 20 => 20);
        $roleDev->syncPermissions($permissionsDev);
        
        
        $roleCust = Role::create(['name' => 'Customer']);
        $permissionsCust = array( 13 => 13, 14 => 14, 15 => 15, 16 => 16);
        $roleCust->syncPermissions($permissionsCust);
        
    }
}