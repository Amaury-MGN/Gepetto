<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');

            $table->string('orderNumber')->unique();
            $table->string('orderName');
            $table->integer('orderItems');
            $table->text('orderContents')->nullable();
            $table->text('orderProgress');
            $table->string('orderAdminFileName');
            $table->string('orderAdminFilePath');
            $table->string('orderInvoice')->nullable();
            $table->string('orderPrice');
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
        Schema::dropIfExists('orders');
    }
}
