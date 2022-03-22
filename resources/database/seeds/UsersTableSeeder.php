<?php

use Illuminate\Database\Seeder;
use App\Model\Role;
use App\Model\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $godRole = Role::where('name', 'god')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        $god = User::create(['name'=> 'God','email' => 'god@gmail.com','password' => bcrypt('god')]);
        $admin = User::create(['name'=> 'Admin','email' => 'admin@gmail.com','password' => bcrypt('admin')]);
        $user = User::create(['name'=> 'User','email' => 'user@gmail.com','password' => bcrypt('user')]);

        $god->roles()->attach($godRole);
        $admin->roles()->attach($adminRole);
        $user->roles()->attach($userRole);
    }
}
