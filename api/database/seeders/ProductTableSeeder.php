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
                'name'          => 'Pc',
                'quantity'      => 10,
                'value'         => 99.99,
            ],
            [
                'name'          => 'Teclado',
                'quantity'      => 10,
                'value'         => 9.99
            ],
            [
                'name'          => 'Mouse',
                'quantity'      => 10,
                'value'         => 19.99
            ],
            [
                'name'          => 'Monitor',
                'quantity'      => 10,
                'value'         => 1999.99
            ],
            [
                'name'          => 'Fonte',
                'quantity'      => 10,
                'value'         => 199.99
            ],
            [
                'name'          => 'Mouse Pad',
                'quantity'      => 10,
                'value'         => 19.99
            ],
        ];

        foreach($seeders as $seed){
            Product::create($seed);
        }
    }
}
