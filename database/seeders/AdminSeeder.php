<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $admin = Employee::create([
            'name'=> 'Muhammad Ahmed',
        'email'=> "muhammadahmed@gmail.com",
        'password' => Hash::make('123456789'),
        'image' => 'Emlpoyees/images/dv9U04VRTxgGAACnT0y5jgAzGwJumBvFJEV8f25g.jpg',
       ]);
       $admin->assignRole('Admin');
    }
}
