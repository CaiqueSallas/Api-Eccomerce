<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            [
                'name' => 'gabriel',
                'email' => 'gabriel@email.com',
                'password' => 'gabriel1234'
            ],
            [
                'name' => 'Renan',
                'email' => 'renan@email.com',
                'password' => 'renan1234'
            ],
            [
                'name' => 'caique',
                'email' => 'caique@email.com',
                'password' => '1234'
            ],
        ];
        foreach($seeders as $seed){
            DB::table('users')->insert([
                'name' => $seed['name'],
                'email' => $seed['email'],
                'password' => Hash::make($seed['password'])
            ]);
        }

    }
}
