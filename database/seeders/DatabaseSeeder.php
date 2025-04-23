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
               'gender'=>'Male',
               'dob' => '2000-01-01', 
               'username'=>'ubuddyadmin',  
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
               'gender'=>'Male',
               'dob' => '2000-01-01', 
               'username'=>'ubuddyuser',  
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
               'gender'=>'Male',
               'dob' => '2000-01-01', 
               'username'=>'Ishan',  
               'password'=> bcrypt('pishan@123'),
               'image' => 'pishan.jpeg',
            ],
            [
               'name'=>'Athrav',
               'email'=>'tathrv@ubuddy',
               'type'=>0,
               'contact_no'=>0000000000,
               'address'=>'Indore',
               'city'=>'Indore',
               'pincode'=>'451010',
               'gender'=>'Male',
               'dob' => '2000-01-01', 
               'username'=>'Athrav',  
               'password'=> bcrypt('tathrv@123'),
            ],
        ];
        
    
        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']], // Unique condition to match
                $userData
            );
        }
        
    }
}
