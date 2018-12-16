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
            $table->string('user_name')->nullable()->comment('员工姓名');
            $table->string('tel')->nullable()->comment('手机号');
            $table->string('type')->nullable()->comment('任职类型');
            $table->string('position')->nullable()->comment('职务');
            $table->string('year')->nullable()->comment('年度');
            $table->string('team')->nullable()->comment('团队名称');
            $table->string('remark')->nullable()->comment('备注');

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
