<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $role_admin = Role::create([
            'name' => 'admin'
        ]);

        $role_prof = Role::create([
            'name' => 'prof'
        ]);

        $role_etudiant = Role::create([
            'name' => 'etudiant'
        ]);

        $user = Factory(App\User::class)->create([
            'first_name' => 'Mael',
            'name' => 'Administrateur',
            'email' => 'entrepot_dossier@gmail.com',
            'licence' => '',
            'password' => bcrypt('12345678')
        ]);
        $user->save();
        $user->assignRole($role_admin);
    }
}
