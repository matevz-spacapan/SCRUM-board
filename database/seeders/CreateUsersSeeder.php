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
            'name' => 'Admin',
            'surname' => 'Istrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin')
        ]);
        $roleAdmin = Role::create(['name' => 'Administrator']);
        $permissionsAdmin = Permission::pluck('id','id')->all();
        $roleAdmin->syncPermissions($permissionsAdmin);
        $userAdmin->assignRole([$roleAdmin->id]);
        
        $userDev = User::create([
            'username' => 'Developer',
            'name' => 'Devel',
            'surname' => 'Oper',
            'email' => 'devel@devel.com',
            'password' => bcrypt('devel')
        ]);
        $roleUser = Role::create(['name' => 'User']);
        $roleUser->syncPermissions();
        $userDev->assignRole([$roleUser->id]);
        
        $userCust = User::create([
            'username' => 'Customer',
            'name' => 'Cust',
            'surname' => 'Omer',
            'email' => 'cust@cust.com',
            'password' => bcrypt('cust')
        ]);
        $userCust->assignRole([$roleUser->id]);
    }
}