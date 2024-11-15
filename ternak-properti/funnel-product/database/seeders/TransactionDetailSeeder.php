<?php

namespace Database\Seeders;

use App\Models\TransactionDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactionDetails = collect([
            ['transaction_id' => 1, 'product_id' => 1, 'quantity' => 1, 'price' => 10000]
        ]);

        $transactionDetails->each(function ($transactionDetail) {
            TransactionDetail::create($transactionDetail);
        });
    }
}
