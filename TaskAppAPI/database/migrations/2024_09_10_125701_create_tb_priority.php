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
        Schema::create('tb_priority', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 優先度の名前を保存するカラム
            $table->timestamps();
        });

        DB::table('tb_priority')->insert([
            ['id' => 1, 'name' => '低'],
            ['id' => 2, 'name' => '中'],
            ['id' => 3, 'name' => '高'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_priority');
    }
};
