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
        Schema::create('tb_status', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ステータスの名前を保存するカラム
            $table->timestamps();
        });

        // 初期データの挿入
        DB::table('tb_status')->insert([
            ['id' => 1, 'name' => '未着手'],
            ['id' => 2, 'name' => '対応中'],
            ['id' => 3, 'name' => '対応済み'],
            ['id' => 4, 'name' => '完了'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_status');
    }
};
