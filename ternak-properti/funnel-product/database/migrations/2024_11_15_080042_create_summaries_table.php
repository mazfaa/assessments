<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('summaries', function (Blueprint $table) {
      $table->id();
      $table->integer('total_sales');
      $table->integer('customer_amount');
      $table->float('average_purchase', 8, 2);
      $table->integer('customers_that_have_bought_1a')->default(1);
      $table->integer('customers_that_have_not_bought_1b');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('summaries');
  }
};
