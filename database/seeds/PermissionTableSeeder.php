<?php

use Illuminate\Database\Seeder;
use sayhuite\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
            [
                'name' => 'role-list',
                'display_name' => 'Lista de roles',
                'description' => 'Ver solo lista de roles'
            ],
            [
                'name' => 'role-create',
                'display_name' => 'Crear Rol',
                'description' => 'Crear nuevo rol'
            ],
            [
                'name' => 'role-edit',
                'display_name' => 'Editar Rol',
                'description' => 'Editar Rol'
            ],
            [
                'name' => 'role-delete',
                'display_name' => 'Eliminar Rol',
                'description' => 'Eliminar Rol'
            ],
            [
                'name' => 'upload-image',
                'display_name' => 'Subir Imagenes',
                'description' => 'Subir Imagenes'
            ],
            [
                'name' => 'upload-pdf',
                'display_name' => 'Subir PDF',
                'description' => 'Subir PDF'
            ],
            [
                'name' => 'update-pi',
                'display_name' => 'Actualizar PI',
                'description' => 'Actualizar proyectos de inversion'
            ]
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
    }
}
