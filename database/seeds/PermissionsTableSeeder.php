<?php

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Ejecución de Seeder para Implementación de Permisos por Roles
         * Utilizando la Librería Spatie Laravel
         */

        //Asignación de Rol Técnico CosHig
        $role = Role::where('name','tecnico_coshig')->first();
        $permissions = Permission::where('aplicacion',21)->get();
        foreach ($permissions as $permit)
        {
            if(!in_array($permit->id,[13,21,29,36,70]))
                $role->givePermissionTo($permit);
        }
        $usersInit = User::whereNotIn('id',[1,3,12,14,23,27])->get(); //Ya deben Existir los usuarios en la tabla

        foreach ($usersInit as $user) {
            $user->assignRole('tecnico_coshig');
        }

        $jefaturas = Role::where('name','jefatura_coshig')->first();
        $jefaturas->givePermissionTo($permissions);
        $usersJefes= User::whereIn('id',[3,14])->get(); //Ya deben Existir los usuarios en la tabla

        foreach ($usersJefes as $user) {
            $user->assignRole('jefatura_coshig');
        }

        $admins = User::whereIn('id',[1,27])->get();

        foreach ($admins as $admin) {
            $admin->assignRole('admin_it');
        }

        $role = Role::create(['name'=>'consulta_uadc','guard_name'=>'web','aplicacion'=>21,'descripcion'=>'Usuario de Consulta UADC']);

        $role->givePermissionTo([11,15,23,31,38,44,47,50,52,54,56,58,60,62,64,66,71,72,82]);

        $uadc = User::find(12);
        $uadc->assignRole('consulta_uadc');

    }
}
