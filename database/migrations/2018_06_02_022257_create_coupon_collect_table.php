<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponCollectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_collect', function (Blueprint $table) {
            $table->increments('id');
            $table->char('uid',29)->comment('用户唯一值');
            $table->unsignedInteger('mid')->comment('用户id');
            $table->unsignedInteger('cid')->comment('优惠券id');

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
        Schema::dropIfExists('coupon_collect');
    }
}
