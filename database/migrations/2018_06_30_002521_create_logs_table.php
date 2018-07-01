<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->increments('id');
            $table->char('log_id',22)->unique()->comment('日志编号 LG20180619122454123456');
            $table->string('title',255)->comment('日志描述');
            $table->text('info')->nullable()->comment('详细信息');
            $table->text('extend')->nullable()->comment('扩展字段');
            $table->unsignedTinyInteger('type')->default(1)->comment('日志类型 1日常 2警告 3危险');

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
        Schema::dropIfExists('logs');
    }
}
