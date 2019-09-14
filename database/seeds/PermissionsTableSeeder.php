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
                'slug'        => 'sync.create',
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
                'slug'        => 'application.create',
                'description' => 'Can Create CMS and ERP',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Update CMS and ERP',
                'slug'        => 'application.update',
                'description' => 'Can update CMS and ERP',
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
