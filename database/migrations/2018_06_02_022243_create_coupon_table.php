<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('send_type')->default(1)->comment('优惠券发放类型 1.注册完成发送 2.完成订单发送 ....');
            $table->string('object',50)->nullable()->comment('使用对象，为空时通用');
            $table->string('title',100)->unique()->comment('优惠券标题');
            $table->text('describes')->comment('优惠券详细介绍');
            $table->string('promotions_detail',255)->comment('优惠信息，序列化数组展示数据');

            $table->float('use_limit',8,2)->nullable()->comment('使用金额限制，为0时不限制');
            $table->string('time_limit',255)->nullable()->comment('使用期限，序列化数组展示数据');

            $table->unsignedInteger('stock')->default(0)->comment('库存字段');

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
        Schema::dropIfExists('coupon');
    }
}
