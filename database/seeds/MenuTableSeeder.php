<?php

use App\Menu;
use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Menu::create([
            'name'      => 'Home',
            'link'      => '/',
            'desc'      => 'Home page de l\'application',
            'text'      => 'admin menu home',
            'permition' => '*',
        ]);
        
        Menu::create([
            'name'      => 'User',
            'link'      => '/users',
            'desc'      => 'gestion des utilisateus',
            'text'      => 'admin menu user',
            'permition' => 'users.view|users.create|users.edit|users.delete',
        ]);
        

        Menu::create([
            'name'      => 'Syncronisation',
            'link'      => 'syncronisation',
            'desc'      => 'gestion des synchronisation',
            'text'      => 'admin menu sync',
            'permition' => 'sync.store|sync.delete',
        ]);

        Menu::create([
            'name'      => 'Application',
            'link'      => 'application',
            'desc'      => 'gestion des applicatoin a intégrer',
            'text'      => 'admin menu app',
            'permition' => 'application.store|application.delete',
        ]);

        //création du menu permition et les sous menus qui vas avec  
        $menu = Menu::create([
            'name'      => 'Restrictions',
            'link'      => '',
            'desc'      => 'gestion des restriction des utilisateurs',
            'text'      => 'admin menu userauthorize',
            'permition' => 'permission.store|permission.delete|role.view|role.create|role.edit|role.delete',
        ]);

        Menu::create([
            'name'      => 'Permission',
            'link'      => 'permission',
            'desc'      => 'gestion des permission',
            'text'      => 'admin menu permission',
            'parent'    => $menu->id ,
            'permition' => 'permission.view',
        ]);

        Menu::create([
            'name'      => 'Role',
            'link'      => 'role',
            'desc'      => 'gestion des role',
            'text'      => 'admin menu role',
            'parent'    => $menu->id ,
            'permition' => 'role.view|role.create|role.edit|role.delete',
        ]);

    }
} 
