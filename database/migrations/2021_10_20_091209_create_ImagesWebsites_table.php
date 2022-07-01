<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesWebsitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images_websites', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('webPage');
            $table->string('firstImage')->nullable();
            $table->string('secondImage')->nullable();
            $table->string('thirdImage')->nullable();
            $table->string('fourthImage')->nullable();

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
        Schema::dropIfExists('imgs');
    }
}
