<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function check_password_success()
    {
        // テストユーザーを作成
        $user = User::factory()->create([
            'password' => Hash::make('password123')
        ]);

        // Sanctumでユーザーとして認証
        Sanctum::actingAs($user, ['*']);

        // 認証された状態でパスワードをチェック
        $response = $this->postJson("/api/users/{$user->id}/check-password", [
            'password' => 'password123',
        ]);

        // レスポンスの検証
        $response->assertStatus(200)
            ->assertExactJson(['Password is correct']);
    }

    #[Test]
    public function check_password_incorrect()
    {
        // テストユーザーを作成
        $user = User::factory()->create([
            'password' => Hash::make('password123')
        ]);

        // Sanctumでユーザーとして認証
        Sanctum::actingAs($user, ['*']);

        // 認証された状態でパスワードが間違っている場合
        $response = $this->postJson("/api/users/{$user->id}/check-password", [
            'password' => 'wrongpassword',
        ]);

        // レスポンスの検証
        $response->assertStatus(401)
            ->assertExactJson(['Password is incorrect']);
    }

    #[Test]
    public function check_password_user_not_found()
    {
        // 他のユーザーの認証情報をセット
        $user = User::factory()->create();

        // Sanctumでユーザーとして認証
        Sanctum::actingAs($user, ['*']);

        // 存在しないユーザーIDでリクエスト
        $response = $this->postJson("/api/users/999/check-password", [
            'password' => 'password123',
        ]);

        // レスポンスの検証
        $response->assertStatus(404)
            ->assertExactJson(['User not found']);
    }

    #[Test]
    public function check_password_validation_error()
    {
        // テストユーザーを作成
        $user = User::factory()->create();

        // Sanctumでユーザーとして認証
        Sanctum::actingAs($user, ['*']);

        // パスワードが空の場合のリクエスト
        $response = $this->postJson("/api/users/{$user->id}/check-password", [
            'password' => '', // 空のパスワードを送信
        ]);

        // レスポンスの検証
        $response->assertStatus(422);
    }
}
