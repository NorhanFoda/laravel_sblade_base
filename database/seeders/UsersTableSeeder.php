<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $permissions = Permission::where('guard_name', 'web')->get();
        $role = Role::findOrCreate('admin', 'web');
        $role->update(['can_be_deleted' => 0]);
        $role->givePermissionTo($permissions);
        $user = User::where('email' , 'admin@admin.com')->first();
        if (!$user){
            $user = User::create([
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => 123456,
            ]);
        }
        $user->assignRole($role);

        for ($i = 1; $i < 100; $i++) {
            $user = User::create([
                'name' => 'user' . $i,
                'email' => 'user' . $i . '@admin.com',
                'password' => 123456,
            ]);
        }
    }
}
