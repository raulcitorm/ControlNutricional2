<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermisionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rol = Role::create(['name' =>'admin']);

        $permission = Permission::create(['name' => 'Todo']);

        $rol->givePermissionTo($permission);

        $user = User::find(1);
        $user->assignRole('admin');

        $rol2 = Role::create(['name' =>'user']);

        $permission2 = Permission::create(['name' => 'no puede eliminar']);

        $rol2->givePermissionTo($permission2);

        $user2 = User::find(2);
        $user2->assignRole('user');

    }
}
