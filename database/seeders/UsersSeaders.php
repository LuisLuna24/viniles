<?php

namespace Database\Seeders;

use App\Models\type_users;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersSeaders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $typeUsers = [
            ['name' => 'Admin'],
            ['name' => 'Docente'],
            ['name' => 'Alumno'],
        ];

        foreach ($typeUsers as $item) {
            type_users::firstOrCreate(
                ['nombre' => $item['name']],
            );
        }

        $user = new User();
        $user->name = "Admin";
        $user->email = "admin@gmail.com";
        $user->password = "Admin123#";
        $user->estatus = "1";
        $user->type_user_id  = 1;
        $user->save();

        $permissions = [
            ['name' => 'users'],
            ['name' => 'user.edit'],
            ['name' => 'user.create'],
            ['name' => 'user.delete'],
            ['name' => 'user.read'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                ['guard_name' => 'sanctum']
            );
        }

        $roleAdmin = Role::firstOrCreate(
            ['name' => 'Admin'],
            ['guard_name' => 'sanctum']
        );

        $roleAdmin->syncPermissions(Permission::where('guard_name', 'sanctum')->get());
        $user->assignRole($roleAdmin);
    }
}
