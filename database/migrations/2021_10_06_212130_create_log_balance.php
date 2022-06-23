<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogBalance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_balance', function (Blueprint $table) {
            $table->id();
            $table->string('type',1)->nullable()->comment('C-Credit / D-Debit');
            $table->decimal('amount',10,2)->nullable();
            $table->decimal('previous_balance',10,2)->nullable();
            $table->decimal('new_balance',10,2)->nullable();
            $table->unsignedBigInteger('deposit_id')->nullable();
            $table->unsignedBigInteger('buy_id')->nullable();
            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('buy_id')->references('id')->on('buys');
            $table->foreign('deposit_id')->references('id')->on('deposits');

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
        Schema::dropIfExists('log_balance');
    }
}
