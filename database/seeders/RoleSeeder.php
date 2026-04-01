<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdminRole = Role::firstOrCreate(['name' => 'super admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $users = User::all();
        
        foreach($users as $user) {
            if ($user->id === 1 || (isset($user->role) && $user->role === 'super admin')) {
                $user->assignRole($superAdminRole);
            } else {
                $user->assignRole($adminRole);
            }
        }
    }
}
