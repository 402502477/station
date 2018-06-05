<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntegralTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integral', function (Blueprint $table) {
            $table->increments('id');
            $table->char('uid',29)->comment('用户唯一值');
            $table->unsignedInteger('mid')->comment('用户id');
            $table->float('point',8,2)->comment('积分点')->default(0.00);
            $table->unsignedTinyInteger('transfer_type')->comment('积分转换类型 1转入 2转出');
            $table->string('describes',100)->comment('描述');

            $table->text('extend')->nullable()->comment('扩展字段');
            $table->unsignedTinyInteger('status')->nullable()->default(1);
            $table->unsignedInteger('create_at')->nullable();
            $table->unsignedInteger('update_at')->nullable();
            $table->unsignedInteger('delete_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('integral');
    }
}
