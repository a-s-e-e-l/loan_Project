<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->string('creditor_phone');
            $table->string('lender_phone');
            $table->double('amount_debt');
            $table->dateTime('deadline');
            $table->timestamps();
            $table->foreign('creditor_phone')->references('phone_number')->on('users');
            $table->foreign('lender_phone')->references('phone_number')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('debts');
    }
}
