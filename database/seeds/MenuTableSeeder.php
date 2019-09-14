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
            'link'      => '',
            'desc'      => 'Home page de l\'application',
            'text'      => 'admin menu home',
            'permition' => '*',
        ]);
        
        Menu::create([
            'name'      => 'User',
            'link'      => 'users',
            'desc'      => 'gestion des utilisateus',
            'text'      => 'admin menu user',
            'permition' => 'users.',
        ]);

        Menu::create([
            'name'      => 'Syncronisation',
            'link'      => 'syncronisation',
            'desc'      => 'gestion des synchronisation',
            'text'      => 'admin menu sync',
            'permition' => 'sync.',
        ]);

        Menu::create([
            'name'      => 'Application',
            'link'      => 'application',
            'desc'      => 'gestion des applicatoin a intégrer',
            'text'      => 'admin menu app',
            'permition' => 'application.',
        ]);

    }
}
