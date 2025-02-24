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
               'username'=>'ubuddyadmin',
               'email'=>'superadmin@ubuddyapp.com',
               'type'=>1,
               'contact_no'=>9876543211,
               'address'=>'Indore',
               'city'=>'Indore',
               'pincode'=>'451010',
               'password'=> bcrypt('Ubuddy$$19'),
            ],
            [
               'name'=>'User',
               'username'=>'ubuddyuser',
               'email'=>'user@ubuddy.com',
               'type'=>0,
               'contact_no'=>0000000000,
               'address'=>'Indore',
               'city'=>'Indore',
               'pincode'=>'451010',
               'password'=> bcrypt('123456'),
            ],
        ];
    
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
