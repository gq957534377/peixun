<?php

use Jialeo\LaravelSchemaExtend\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelHonorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rel_honors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('year')->nullable()->comment('年度');
            $table->unsignedInteger('honor_id')->nullable()->comment('奖项id');
            $table->unsignedInteger('user_id')->nullable()->comment('获奖人id');
            $table->string('comment')->nullable()->comment('备注');

            $table->string('name')->nullable()->comment('奖项名称');
            $table->string('user')->nullable()->comment('获奖人');

            $table->timestamps();
            $table->comment = '历年荣誉获得信息表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rel_honors');
    }
}
