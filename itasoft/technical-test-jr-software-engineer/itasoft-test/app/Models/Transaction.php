<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'total_quantity', 'total_price'];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function transactionDetails() {
        return $this->hasMany(TransactionDetail::class);
    }

    public function products() {
        return $this->hasManyThrough(Product::class, TransactionDetail::class, 'transaction_id', 'id', 'id', 'product_id');
    }
}
