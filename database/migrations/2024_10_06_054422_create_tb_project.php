<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTbProject extends Migration
{
    public function up()
    {
        Schema::create('tb_project', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->string('name', 255)->comment('プロジェクト名');
            $table->boolean('is_complete')->default(false)->comment('完了フラグ');
            $table->timestamps();
            $table->string('created_by', 255)->comment('作成者');
            $table->string('updated_by', 255)->comment('更新者');
            $table->integer('update_count')->comment('更新回数');
        });

        DB::table('tb_project')->insert([
            [
                'id' => 1,
                'name' => 'プロジェクト',
                'is_complete' => false,
                'created_by' => 'user1',
                'updated_by' => 'user1',
                'update_count' => 0
            ]
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('tb_project');
    }
}
