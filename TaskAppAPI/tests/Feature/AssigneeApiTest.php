<?php

namespace Tests\Feature;

use App\Models\Assignee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AssigneeApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 担当者の一覧を取得できるかテスト.
     *
     * @return void
     */
    public function test_can_get_assignees()
    {
        // 認証ユーザーの作成
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // ダミーの担当者を作成
        Assignee::factory()->create([
            'name' => 'Test Assignee',
        ]);

        // GETリクエストを送信して担当者一覧を取得
        $response = $this->getJson('/api/assignees');

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
     * 担当者を作成できるかテスト.
     *
     * @return void
     */
    public function test_can_create_assignee()
    {
        // 認証ユーザーの作成
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // POSTリクエストで担当者を作成
        $response = $this->postJson('/api/assignees', [
            'name' => 'New Assignee',
        ]);

        // ステータスコード201を期待
        $response->assertStatus(201);

        // データベースに新しい担当者があるか確認
        $this->assertDatabaseHas('tb_assignee', [
            'name' => 'New Assignee',
        ]);
    }

    /**
     * 担当者を更新できるかテスト.
     *
     * @return void
     */
    public function test_can_update_assignee()
    {
        // 認証ユーザーの作成
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // ダミーの担当者を作成
        $assignee = Assignee::factory()->create([
            'name' => 'Old Assignee',
        ]);

        // PUTリクエストで担当者を更新
        $response = $this->putJson("/api/assignees/{$assignee->id}", [
            'name' => 'Updated Assignee',
            'updated_by' => 'admin',
        ]);

        // ステータスコード200を期待
        $response->assertStatus(200);

        // データベースが更新されたことを確認
        $this->assertDatabaseHas('tb_assignee', [
            'id' => $assignee->id,
            'name' => 'Updated Assignee',
        ]);
    }

    /**
     * 担当者を削除できるかテスト.
     *
     * @return void
     */
    public function test_can_delete_assignee()
    {
        // 認証ユーザーの作成
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // ダミーの担当者を作成
        $assignee = Assignee::factory()->create([
            'name' => 'Assignee to be deleted',
        ]);

        // DELETEリクエストで担当者を削除
        $response = $this->deleteJson("/api/assignees/{$assignee->id}");

        // ステータスコード200を期待
        $response->assertStatus(200);

        // データベースから担当者が削除されたことを確認
        $this->assertDatabaseMissing('tb_assignee', [
            'id' => $assignee->id,
        ]);
    }
}
