<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimates', function (Blueprint $table) {
            // estimate from User
            $table->bigIncrements('id');
            $table->bigInteger('user_id');

            $table->string('estimateName');
            $table->integer('estimateItemNumber');
            $table->text('estimateContents');
            $table->string('estimateUserFile');
            $table->string('estimateNumber');
            $table->string('estimateUserFileName');
            $table->string('paymentValidation')->default('Non');

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
        Schema::dropIfExists('estimates');
    }
}
