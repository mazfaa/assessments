<?php

namespace App\Http\Controllers;

use App\Exports\SummaryExport;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Maatwebsite\Excel\Facades\Excel;

class SummaryController extends Controller
{
  public static function middleware(): array
  {
    return [
      new Middleware('role:admin', only: ['index']),
    ];
  }

  public function index()
  {
    $total_sales = Transaction::count();
    $customer_amount = Transaction::distinct('user_id')->count();
    $average_purchase = Transaction::avg('total_price');
    $customers_that_have_bought_1a = User::where('bought_1a', true)
      ->whereDoesntHave('roles', function ($query) {
        $query->where('name', 'admin');
      })
      ->count();

    $customers_that_have_not_bought_1b = User::where('bought_1b', false)
      ->whereDoesntHave('roles', function ($query) {
        $query->where('name', 'admin');
      })
      ->count();
    // $customers_that_have_bought_1a = User::where('bought_1b', true)->count();
    // $customers_that_have_not_bought_1b = User::where('bought_1b', false)->count();

    return view('summary.index', compact('total_sales', 'customer_amount', 'average_purchase', 'customers_that_have_bought_1a', 'customers_that_have_not_bought_1b'));
  }

  public function export()
  {
    return Excel::download(new SummaryExport, 'summary.xlsx');
  }
}
