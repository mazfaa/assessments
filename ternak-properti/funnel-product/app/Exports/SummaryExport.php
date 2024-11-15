<?php

namespace App\Exports;

use App\Models\Summary;
use App\Models\Transaction;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SummaryExport implements FromCollection, WithHeadings
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    $total_sales = Transaction::count();
    $customer_amount = Transaction::distinct('user_id')->count();
    $average_purchase = Transaction::avg('total_price');
    $customers_that_have_bought_1a = User::where('bought_1b', true)->count();
    $customers_that_have_not_bought_1b = User::where('bought_1b', false)->count();

    return collect([
      [
        'total_sales' => $total_sales,
        'customer_amount' => $customer_amount,
        'average_purchase' => $average_purchase,
        'customers_that_have_bought_1a' => $customers_that_have_bought_1a,
        'customers_that_have_not_bought_1b' => $customers_that_have_not_bought_1b,
      ]
    ]);
  }

  public function headings(): array
  {
    return [
      'total_sales',
      'customer_amount',
      'average_purchase',
      'customers_that_have_bought_1a',
      'customers_that_have_not_bought_1b',
    ];
  }
}
