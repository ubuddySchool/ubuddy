<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
  
class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $users = [
            [
               'name'=>'Admin',
               'email'=>'superadmin@ubuddyapp.com',
               'contact_no'=>9876543211,
               'address'=>'Indore',
               'city'=>'Indore',
               'pincode'=>'451010',
               'username'=>'ubuddyadmin',  
               'type'=>1,
               'password'=> bcrypt('Ubuddy$$19'),
            ],
            [
               'name'=>'User',
               'email'=>'user@ubuddy.com',
               'contact_no'=>0000000000,
               'address'=>'Indore',
               'city'=>'Indore',
               'pincode'=>'451010',
               'username'=>'ubuddyuser',  // Ensure username is provided
               'type'=>0,
               'password'=> bcrypt('123456'),
            ],
        ];
        
    
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
