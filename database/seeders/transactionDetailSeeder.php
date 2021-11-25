<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionDetailSeeder extends Seeder
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
                'transaction_id' => '1',
                'transaction_category_id' => '1',
                'name' => 'Rental Mobil Bulan Oktober',
                'value_idr' => '800000',
            ],
            [
                'transaction_id' => '1',
                'transaction_category_id' => '1',
                'name' => 'Bensin',
                'value_idr' => '100000',
            ],
            [
                'transaction_id' => '1',
                'transaction_category_id' => '2',
                'name' => 'Bayar Sopir',
                'value_idr' => '300000',
            ],
            //
            [
                'transaction_id' => '2',
                'transaction_category_id' => '1',
                'name' => 'Rental Mobil Minggu ke2',
                'value_idr' => '600000',
            ],
            [
                'transaction_id' => '2',
                'transaction_category_id' => '1',
                'name' => 'Bensin',
                'value_idr' => '100000',
            ],
            [
                'transaction_id' => '2',
                'transaction_category_id' => '2',
                'name' => 'Bayar Sopir',
                'value_idr' => '300000',
            ],
            //
            [
                'transaction_id' => '3',
                'transaction_category_id' => '1',
                'name' => 'Rental Mobil Bulan November',
                'value_idr' => '800000',
            ],
            [
                'transaction_id' => '3',
                'transaction_category_id' => '1',
                'name' => 'Bensin',
                'value_idr' => '100000',
            ],
            [
                'transaction_id' => '3',
                'transaction_category_id' => '2',
                'name' => 'Bayar Sopir',
                'value_idr' => '300000',
            ],
            //
            [
                'transaction_id' => '4',
                'transaction_category_id' => '1',
                'name' => 'Rental Mobil Minggu ke2',
                'value_idr' => '600000',
            ],
            [
                'transaction_id' => '4',
                'transaction_category_id' => '1',
                'name' => 'Bensin',
                'value_idr' => '100000',
            ],
            [
                'transaction_id' => '4',
                'transaction_category_id' => '2',
                'name' => 'Bayar Sopir',
                'value_idr' => '300000',
            ],
        ];
        DB::table('transaction_detail')->insert($data);
    }
}
