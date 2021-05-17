<?php

namespace Database\Seeders;

use App\Models\PaymentStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentStatusTableSeeder extends Seeder
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
                'id'    => 1,
                'name'  => 'Pago'
            ],
            [
                'id'    => 2,
                'name'  => 'Aguardando pagamento'
            ],
            [
                'id'    => 3,
                'name'  => 'Cancelado'
            ]
        ];

        foreach($seeders as $seed) {
            DB::table('payment_status')->insert($seed);
        }
    }
}
