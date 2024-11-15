<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Transaction::with('user')->get()->map(function ($transaction) {
            return [
                'ID' => $transaction->id,
                'Customer Name' => $transaction->user->name,
                'Total Quantity' => $transaction->total_quantity,
                'Total Price' => $transaction->total_price,
                'Transaction Date' => $transaction->created_at->format('d M Y, H:i'),
            ];
        });
    }

     public function headings(): array
     {
        return [
            'ID',
            'Customer Name',
            'Total Quantity',
            'Total Price',
            'Transaction Date',
        ];
     }
}
