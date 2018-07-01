<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->char('order_id',30)->unique()->comment('订单编号 XX + time(201705061224511) + uid + rand*4');
            $table->float('original_point',8,2)->default(0.00)->comment('订单原价/原积分');
            $table->float('current_point',8,2)->default(0.00)->comment('订单现价/现积分');
            $table->string('promotions_info',255)->nullable()->comment('优惠信息');
            $table->string('goods_info',255)->nullable()->comment('商品信息');

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
        Schema::dropIfExists('orders');
    }
}
