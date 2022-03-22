<?php

use Illuminate\Database\Seeder;
use App\Model\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Role::truncate();
        Role::create(['name'=> 'god']);
        Role::create(['name'=> 'admin']);
        Role::create(['name'=> 'user']);
    }
}
