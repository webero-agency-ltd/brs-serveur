<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Permission Types
         *
         */
        $Permissionitems = [
            //permitiopn sur lest utilisateurs
            [
                'name'        => 'Can View Users',
                'slug'        => 'users.view',
                'description' => 'Can view users',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Create Users',
                'slug'        => 'users.create',
                'description' => 'Can create new users',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Edit Users',
                'slug'        => 'users.edit',
                'description' => 'Can edit users',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Delete Users',
                'slug'        => 'users.delete',
                'description' => 'Can delete users',
                'model'       => 'Permission',
            ],

            //permition sur les permition ( crée des persmition , assingation, etc ... )

            //permition sur la service comptabilité 
            [
                'name'        => 'Can Sync Users Vos Facture',
                'slug'        => 'sync.store',
                'description' => 'Can Sync Users Vos Facture',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can users Sync Users Vos Facture',
                'slug'        => 'sync.delete',
                'description' => 'Can users Sync Users Vos Facture',
                'model'       => 'Permission',
            ],
            //création est mise a jour des applications a intégrer 
            [
                'name'        => 'Can Create CMS and ERP',
                'slug'        => 'application.store',
                'description' => 'Can Create CMS and ERP',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Update CMS and ERP',
                'slug'        => 'application.update',
                'description' => 'Can update CMS and ERP',
                'model'       => 'Permission',
            ],
            /**
             * permition sur la manipulation des différents permission et de role
             */
            //role
            [
                'name'        => 'Can Create Role',
                'slug'        => 'role.store',
                'description' => 'Can Create Role',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Delete Role',
                'slug'        => 'role.delete',
                'description' => 'Can Delete Role',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can View Role',
                'slug'        => 'role.view',
                'description' => 'Can View Role',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Update Role',
                'slug'        => 'role.update',
                'description' => 'Can Update Role',
                'model'       => 'Permission',
            ],
            //permition
            [
                'name'        => 'Can View Permission',
                'slug'        => 'permission.view',
                'description' => 'Can View Permission',
                'model'       => 'Permission',
            ],
        ];

        /*
         * Add Permission Items
         *
         */
        foreach ($Permissionitems as $Permissionitem) {
            $newPermissionitem = config('roles.models.permission')::where('slug', '=', $Permissionitem['slug'])->first();
            if ($newPermissionitem === null) {
                $newPermissionitem = config('roles.models.permission')::create([
                    'name'          => $Permissionitem['name'],
                    'slug'          => $Permissionitem['slug'],
                    'description'   => $Permissionitem['description'],
                    'model'         => $Permissionitem['model'],
                ]);
            }
        }
    }
}
