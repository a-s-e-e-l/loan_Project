<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('payer_phone');
            $table->string('recipient_phone');
            $table->double('amount');
            $table->dateTime('deadline')->nullable();
            $table->boolean('agree')->default(false);
            $table->enum('type', ['Payment', 'debt']);
            $table->string('note')->nullable();
            $table->foreign('payer_phone')->references('phone_number')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('recipient_phone')->references('phone_number')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
