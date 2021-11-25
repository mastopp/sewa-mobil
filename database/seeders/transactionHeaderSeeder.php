<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionHeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'description' => 'Transaksi Bulan Oktober',
                'code' => '123456',
                'rate_euro' => '15000',
                'date_paid' => '2021-10-01',
            ],
            [
                'description' => 'Transaksi minggu ke2',
                'code' => '7890',
                'rate_euro' => '15000',
                'date_paid' => '2021-10-10',
            ],
            [
                'description' => 'Transaksi Bulan November',
                'code' => '123456',
                'rate_euro' => '15000',
                'date_paid' => '2021-11-01',
            ],
            [
                'description' => 'Transaksi minggu ke2',
                'code' => '7890',
                'rate_euro' => '15000',
                'date_paid' => '2021-11-10',
            ],
        ];
        DB::table('transaction_header')->insert($data);
    }
}
