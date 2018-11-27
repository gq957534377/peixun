<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('position')->nullable()->comment('职务');
            $table->string('year')->nullable()->comment('年度');
            $table->unsignedInteger('user_id')->nullable()->comment('用户id');
            $table->string('comment')->nullable()->comment('备注');
            $table->string('name')->nullable()->comment('名字');

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
        Schema::dropIfExists('positions');
    }
}
