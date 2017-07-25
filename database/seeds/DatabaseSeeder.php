<?php

use Illuminate\Database\Seeder;
use App\Widget;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        // Usando definicoes do faker criadas em database/factories/ModelFactory.php 
        Widget::unguard();
        Widget::truncate();
        factory(App\Widget::class, 20)->create();
        Widget::reguard();
    }

    
}
