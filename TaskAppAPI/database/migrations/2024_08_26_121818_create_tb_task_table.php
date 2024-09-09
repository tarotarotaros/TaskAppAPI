<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_task_table', function (Blueprint $table) {
            $table->increments('task_id')->comment('タスクID');
            $table->char('task_name')->comment('タスク名');
            $table->char('content')->nullable()->comment('内容');
            $table->integer('priority')->nullable()->comment('優先度');
            $table->date('deadline')->nullable()->comment('期限日');
            $table->integer('project')->nullable()->comment('プロジェクト');
            $table->integer('status')->nullable()->comment('ステータス');
            $table->integer('miled')->nullable()->comment('マイルストーン');
            $table->time('milestone')->nullable()->comment('実績時間');
            $table->char('manager')->nullable()->comment('担当者');
            // 'create_date' と 'update_date' は不要になる
            $table->timestamps(); // これが 'created_at' と 'updated_at' を作成
            $table->char('created_by')->comment('作成者');
            $table->char('updated_by')->comment('更新者');
            $table->integer('update_count')->comment('更新回数');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_task_table');
    }
}
