<?php

namespace Tests\Feature;

use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StatusApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ステータス一覧を取得できるかテスト.
     *
     * @return void
     */
    public function test_can_get_statuses()
    {
        // 認証ユーザーの作成
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // ダミーステータスを作成
        Status::factory()->create([
            'name' => 'Test Status',
            'color' => 'red',
        ]);

        // GETリクエストを送信してステータス一覧を取得
        $response = $this->getJson('/api/statuses');

        // ステータスコード200を期待
        $response->assertStatus(200);

        // JSONの構造を確認
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'color',
                'created_at',
                'updated_at',
            ]
        ]);
    }

    /**
     * ステータスを作成できるかテスト.
     *
     * @return void
     */
    public function test_can_create_status()
    {
        // 認証ユーザーの作成
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // POSTリクエストでステータスを作成
        $response = $this->postJson('/api/statuses', [
            'name' => 'New Status',
            'color' => 'blue',
        ]);

        // ステータスコード201を期待
        $response->assertStatus(201);

        // データベースに新しいステータスがあるか確認
        $this->assertDatabaseHas('tb_status', [
            'name' => 'New Status',
            'color' => 'blue',
        ]);
    }

    /**
     * ステータスを更新できるかテスト.
     *
     * @return void
     */
    public function test_can_update_status()
    {
        // 認証ユーザーの作成
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // ダミーステータスを作成
        $status = Status::factory()->create([
            'name' => 'Old Status',
            'color' => 'green',
        ]);

        // PUTリクエストでステータスを更新
        $response = $this->putJson("/api/statuses/{$status->id}", [
            'name' => 'Updated Status',
            'color' => 'yellow',
            'updated_by' => 'admin',
        ]);

        // ステータスコード200を期待
        $response->assertStatus(200);

        // データベースが更新されたことを確認
        $this->assertDatabaseHas('tb_status', [
            'id' => $status->id,
            'name' => 'Updated Status',
            'color' => 'yellow',
        ]);
    }

    /**
     * ステータスを削除できるかテスト.
     *
     * @return void
     */
    public function test_can_delete_status()
    {
        // 認証ユーザーの作成
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // ダミーステータスを作成
        $status = Status::factory()->create([
            'name' => 'Status to be deleted',
            'color' => 'red',
        ]);

        // DELETEリクエストでステータスを削除
        $response = $this->deleteJson("/api/statuses/{$status->id}");

        // ステータスコード200を期待
        $response->assertStatus(200);

        // データベースからステータスが削除されたことを確認
        $this->assertDatabaseMissing('tb_status', [
            'id' => $status->id,
        ]);
    }
}
