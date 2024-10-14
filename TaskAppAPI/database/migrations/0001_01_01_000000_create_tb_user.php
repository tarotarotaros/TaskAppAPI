<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_user', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->string('name')->comment('ユーザ名');
            $table->string('email')->unique()->comment('メールアドレス');
            $table->timestamp('email_verified_at')->nullable()->comment('メールアドレス確認日時');
            $table->string('password')->comment('パスワード');
            $table->integer('project')->nullable()->comment('プロジェクト');
            $table->string('api_token', 80)->nullable()->unique()->default(null)->comment('APIトークン');
            $table->rememberToken()->comment('ログイン状態保持トークン');
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary()->coment('メールアドレス');
            $table->string('token')->comment('トークン');
            $table->timestamp('created_at')->nullable()->comment('作成日時');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary()->comment('ID');
            $table->foreignId('user_id')->nullable()->index()->comment('ユーザID');
            $table->string('ip_address', 45)->nullable()->comment('IPアドレス');
            $table->text('user_agent')->nullable()->comment('ユーザエージェント');
            $table->longText('payload')->comment('ペイロード');
            $table->integer('last_activity')->index()->comment('最終アクティビティ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_user');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
