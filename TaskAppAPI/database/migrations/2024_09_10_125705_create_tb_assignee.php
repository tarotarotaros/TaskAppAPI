<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_assignee', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 担当者の名前を保存するカラム
            $table->timestamps();
        });

        // 初期データの挿入
        DB::table('tb_assignee')->insert([
            ['id' => 1, 'name' => '未定'],
            ['id' => 2, 'name' => '山田'],
            ['id' => 3, 'name' => '田中'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_assignee');
    }
};
