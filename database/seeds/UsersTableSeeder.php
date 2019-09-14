<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'name' => 'Andriamihaja Heldino',
            'email' => 'ahheldino@mail.com',
            'password' => Hash::make('ahheldino@mail.com'),
        ]);

        //ajoute de l'autorsiation a cette utilisateur 
        $role = config('roles.models.role')::where('name', '=', 'Admin')->first();
        $user->attachRole($role);

        //création d'utilisateur opérateur qui vas faire la sunchronisation 
        $user = User::create([
            'name' => 'Andriamihaja Heldino Operateur',
            'email' => 'operateur@mail.com',
            'password' => Hash::make('operateur@mail.com'),
        ]);

        $role = config('roles.models.role')::where('name', '=', 'Comptable')->first();
        $user->attachRole($role);

        return $user;

    }
}
