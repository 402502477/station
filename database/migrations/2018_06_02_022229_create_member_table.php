<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member', function (Blueprint $table) {
            $table->increments('id');
            $table->char('uid',29)->comment('用户唯一值');
            $table->char('contact',11)->nullable()->comment('用户联系方式');
            $table->string('username',50)->nullable()->comment('用户姓名');
            $table->unsignedTinyInteger('level')->default(1)->comment('会员等级');
            $table->float('balance',8,2)->default(0.00)->comment('现金余额');
            $table->unsignedInteger('coin')->default(0)->comment('金币、积分余额');
            $table->text('info')->nullable()->comment('用户详细信息');
            $table->text('receipt_info')->nullable()->comment('发票信息');
            $table->unique('uid');
            $table->index(['username','balance','coin']);

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
        Schema::dropIfExists('member');
    }
}
