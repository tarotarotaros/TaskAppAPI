<?php

namespace Tests\Feature;

use App\Models\Priority;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PriorityApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 優先度の一覧を取得できるかテスト.
     *
     * @return void
     */
    public function test_can_get_priorities()
    {
        // 認証ユーザーの作成
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // ダミーの優先度を作成
        Priority::factory()->create([
            'name' => 'Test Priority',
        ]);

        // GETリクエストを送信して優先度一覧を取得
        $response = $this->getJson('/api/priorities');

        // ステータスコード200を期待
        $response->assertStatus(200);

        // JSONの構造を確認
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'created_at',
                'updated_at',
            ]
        ]);
    }

    /**
     * 優先度を作成できるかテスト.
     *
     * @return void
     */
    public function test_can_create_priority()
    {
        // 認証ユーザーの作成
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // POSTリクエストで優先度を作成
        $response = $this->postJson('/api/priorities', [
            'name' => 'New Priority',
        ]);

        // ステータスコード201を期待
        $response->assertStatus(201);

        // データベースに新しい優先度があるか確認
        $this->assertDatabaseHas('tb_priority', [
            'name' => 'New Priority',
        ]);
    }

    /**
     * 優先度を更新できるかテスト.
     *
     * @return void
     */
    public function test_can_update_priority()
    {
        // 認証ユーザーの作成
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // ダミーの優先度を作成
        $priority = Priority::factory()->create([
            'name' => 'Old Priority',
        ]);

        // PUTリクエストで優先度を更新
        $response = $this->putJson("/api/priorities/{$priority->id}", [
            'name' => 'Updated Priority',
            'updated_by' => 'admin',
        ]);

        // ステータスコード200を期待
        $response->assertStatus(200);

        // データベースが更新されたことを確認
        $this->assertDatabaseHas('tb_priority', [
            'id' => $priority->id,
            'name' => 'Updated Priority',
        ]);
    }

    /**
     * 優先度を削除できるかテスト.
     *
     * @return void
     */
    public function test_can_delete_priority()
    {
        // 認証ユーザーの作成
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // ダミーの優先度を作成
        $priority = Priority::factory()->create([
            'name' => 'Priority to be deleted',
        ]);

        // DELETEリクエストで優先度を削除
        $response = $this->deleteJson("/api/priorities/{$priority->id}");

        // ステータスコード200を期待
        $response->assertStatus(200);

        // データベースから優先度が削除されたことを確認
        $this->assertDatabaseMissing('tb_priority', [
            'id' => $priority->id,
        ]);
    }
}
