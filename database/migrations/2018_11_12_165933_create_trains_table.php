<?php

use Jialeo\LaravelSchemaExtend\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trains', function (Blueprint $table) {
            $table->increments('id');
            $table->string('year')->nullable()->comment('年度');
            $table->unsignedInteger('course_id')->nullable()->comment('课程id');
            $table->unsignedInteger('student_id')->nullable()->comment('学员id');
            $table->string('comment')->nullable()->comment('备注');

            $table->string('student')->nullable()->comment('学员名字');
            $table->string('course')->nullable()->comment('课程');

            $table->timestamps();
            $table->comment = '历年培训学员信息表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trains');
    }
}
