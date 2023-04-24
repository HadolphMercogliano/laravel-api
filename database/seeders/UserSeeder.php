<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
      $user = new User;
      $user->name = 'Hadolph';
      $user->email = 'hadolph@hadolph.com';
      $user->password = 'password';
      $user->save();
    }
}