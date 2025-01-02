<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create quiz',
            'edit quiz',
            'delete quiz',
            'host quiz',
            'play quiz',
            'review quiz',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $quizhost = Role::firstOrCreate(['name' => 'Quizmaster', 'guard_name' => 'web']);
        $player = Role::firstOrCreate(['name' => 'Player', 'guard_name' => 'web']);

        $superAdmin->givePermissionTo(Permission::all());

        $quizhost->givePermissionTo([
            'create quiz',
            'edit quiz',
            'delete quiz',
            'host quiz',
        ]);

        $player->givePermissionTo([
            'play quiz',
            'review quiz'
        ]);

        $admin = \App\Models\User::find(1);
        $admin->assignRole('Super Admin');
    }
}
