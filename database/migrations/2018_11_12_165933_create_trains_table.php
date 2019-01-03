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
            $table->unsignedInteger('case_id')->nullable()->comment('培训类别id');
            $table->unsignedInteger('student_id')->nullable()->comment('学员id');
            $table->string('case')->nullable()->comment('培训类别');
            $table->string('team')->nullable()->comment('服务队名称');
            $table->string('student')->nullable()->comment('学员名字');
            $table->string('student_tel')->nullable()->comment('联系方式');
            $table->string('remark')->nullable()->comment('备注');

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
