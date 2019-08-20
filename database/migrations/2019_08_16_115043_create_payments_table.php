<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('bunq_monetary_account_id');
            $table->bigInteger('bunq_payment_id');
            $table->bigInteger('splitwise_id')->nullable();

            $table->decimal('value');
            $table->integer('currency');

            $table->text('description')->nullable();
            $table->integer('type');
            $table->integer('sub_type');

            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
