<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

    	Model::unguard();
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ConnectRelationshipsSeeder::class);
        Model::reguard();
        $this->call(UsersTableSeeder::class);
        //seeder du menu 
        $this->call(MenuTableSeeder::class);
    }
}
