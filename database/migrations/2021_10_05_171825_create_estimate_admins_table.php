<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('estimate_id')->Unique();
            $table->double('estimateAdminPrice', 8, 2);
            $table->text('estimateAdminContents');
            $table->string('estimateAdminFileName');
            $table->string('estimateAdminFile');

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
        Schema::dropIfExists('estimate_admins');
    }
}
