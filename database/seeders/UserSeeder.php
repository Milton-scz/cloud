<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission; // Importamos el modelo Permission
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Verificar si el rol "gerente" existe
        $role = Role::firstOrCreate(
            ['name' => 'gerente', 'guard_name' => 'web']
        );

        $permissions = [
            'ver-dashboard',
            'ver-modulo-usuarios',
            'ver-modulo-ventas',
            'ver-modulo-inventario',
            'ver-modulo-reportes',
            'ver-usuarios',
            'ver-roles',
            'ver-permisos',
            'ver-productos',
            'ver-almacenes',
            'ver-categorias',
            'ver-notas-compras',
            'ver-ajustes-inventarios',
            'ver-ofertas',
            'ver-ventas',
            'ver-proveedores',
            'ver-pagos',
            'ver-reportes',
            'ver-views',
            'crear-usuario',
            'editar-usuario',
            'eliminar-usuario',

            'crear-rol',
            'editar-rol',
            'eliminar-rol',

            'crear-permiso',
            'editar-permiso',
            'eliminar-permiso',

            'crear-producto',
            'editar-producto',
            'eliminar-producto',

            'crear-almacen',
            'editar-almacen',
            'eliminar-almacen',

            'crear-categoria',
            'editar-categoria',
            'eliminar-categoria',

            'crear-nota-compra',
            'editar-nota-compra',
            'eliminar-nota-compra',

            'crear-oferta',
            'editar-oferta',
            'eliminar-oferta',

            'crear-proveedor',
            'editar-proveedor',
            'eliminar-proveedor',

            'crear-pago',
            'editar-pago',
            'eliminar-pago',

            'crear-reporte',
            'editar-reporte',
            'eliminar-reporte',

            'crear-view',
            'editar-view',
            'eliminar-view',

            'crear-venta',
            'editar-venta',
            'eliminar-venta',

            'enviar-reportes',

            'eliminar-ajuste-inventario'


        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
            $role->givePermissionTo($permissionName);
        }
        // Asignar el permiso al rol "gerente"


        // Verificar si el usuario "alison@gmail.com" ya existe
        $user = User::where('email', 'kevin@gmail.com')->first();

        if (!$user) {
            // Crear el usuario
            $user = User::create([
                'name' => 'kevin',
                'cedula' => '9877532',
                'celular' => '59176392938',
                'direccion' => 'Zona Norte',
                'email' => 'kevin@gmail.com',
                'password' => Hash::make('admin'),
            ]);

            // Asignar el rol "gerente" al usuario
            $user->assignRole($role);
        }
    }
}
