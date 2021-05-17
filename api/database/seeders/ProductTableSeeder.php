<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
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
                'name'          => 'Pc Gamer',
                'quantity'      => 10,
                'value'         => 99.99,
            ],
            [
                'name'          => 'Teclado Gamer',
                'quantity'      => 10,
                'value'         => 9.99
            ],
            [
                'name'          => 'Mouse',
                'quantity'      => 10,
                'value'         => 19.99
            ],
        ];

        foreach($seeders as $seed){
            Product::create($seed);
        }
    }
}
