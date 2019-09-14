<?php

use Illuminate\Database\Seeder;

class ConnectRelationshipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 
        $permissions = config('roles.models.permission')::all();

        $roleAdmin = config('roles.models.role')::where('name', '=', 'Admin')->first();
        foreach ($permissions as $permission) {
            $roleAdmin->attachPermission($permission);
        }

        //attacher la parmition sync au role comptable
        $permissionsComptable = config('roles.models.permission')::where('slug','like','sync.%')->get(); 
        $roleComptable = config('roles.models.role')::where('name', '=', 'Comptable')->first();
    
        foreach ($permissionsComptable as $permission) {
            $roleComptable->attachPermission($permission);
        }
        
    }
}
