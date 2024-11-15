<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $fillable = ['name', 'price', 'stock', 'category'];

  public function transactions()
  {
    return $this->hasMany(Transaction::class);
  }
}
