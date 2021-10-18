<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->decimal('amount',10,2);
            $table->decimal('pay_per_week',10,2);
            $table->decimal('amount_to_pay',10,2);
            $table->decimal('interest',10,2);
            $table->integer('duration');
            $table->dateTime('date_applied');
            $table->dateTime('date_loan_ends');
            $table->tinyInteger('approved')->nullable();
            $table->dateTime('approved_date')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('status', ['unpaid','paid','partial'])->default('unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
