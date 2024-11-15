<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // $transactions = collect([
    //   ['code' => date('Y-m') . '-000' . (Transaction::count() + 1), 'user_id' => 2, 'total_quantity' => 1, 'total_price' => 10000]
    // ]);

    // $transactions->each(function ($transaction) {
    //   Transaction::create($transaction);
    // });
  }
}
