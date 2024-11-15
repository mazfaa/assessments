<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Product::create(['name' => 'POS Management System', 'category' => '1a', 'price' => 40000, 'stock' => 80]);
    Product::create(['name' => 'Risk Management System', 'category' => '1b', 'price' => 10000, 'stock' => 25]);
    Product::create(['name' => 'HRIS Management System', 'category' => '1a', 'price' => 25000, 'stock' => 50]);
    Product::create(['name' => 'Rental Management System', 'category' => '1b', 'price' => 40000, 'stock' => 10]);
    Product::create(['name' => 'Payroll Management System', 'category' => '1a', 'price' => 40000, 'stock' => 15]);
    Product::create(['name' => 'Accounting Management System', 'category' => '1b', 'price' => 40000, 'stock' => 30]);
    Product::create(['name' => 'Attendance Management System', 'category' => '1a', 'price' => 40000, 'stock' => 40]);
    Product::create(['name' => 'Election/Voting Management System', 'category' => '1b', 'price' => 40000, 'stock' => 40]);
  }
}
