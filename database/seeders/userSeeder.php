<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Agregamos los bloques de la universidad
        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@hotmail.com';
        $user->password = Hash::make('12345678');
        $user->role = 'admin';
        $user->save();
    }
}
