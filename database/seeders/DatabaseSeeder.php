<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
               'name'=>'Admin',
               'email'=>'superadmin@ubuddyapp.com',
               'type'=>1,
               'contact_no'=>9876543211,
               'address'=>'Indore',
               'city'=>'Indore',
               'pincode'=>'451010',
               'username'=>'ubuddyadmin',  // Ensure username is provided
               'password'=> bcrypt('Ubuddy$$19'),
            ],
            [
               'name'=>'User',
               'email'=>'user@ubuddy.com',
               'type'=>0,
               'contact_no'=>0000000000,
               'address'=>'Indore',
               'city'=>'Indore',
               'pincode'=>'451010',
               'username'=>'ubuddyuser',  // Ensure username is provided
               'password'=> bcrypt('123456'),
            ],
            [
               'name'=>'Ishan',
               'email'=>'pishan@ubuddy',
               'type'=>0,
               'contact_no'=>0000000000,
               'address'=>'Indore',
               'city'=>'Indore',
               'pincode'=>'451010',
               'username'=>'Ishan',  
               'password'=> bcrypt('pishan@123'),
            ],
            [
               'name'=>'Athrav',
               'email'=>'tathrv@ubuddy',
               'type'=>0,
               'contact_no'=>0000000000,
               'address'=>'Indore',
               'city'=>'Indore',
               'pincode'=>'451010',
               'username'=>'Athrav',  
               'password'=> bcrypt('tathrv@123'),
            ],
        ];
        
    
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
