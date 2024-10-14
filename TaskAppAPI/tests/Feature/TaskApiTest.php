<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use App\Models\Task;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * タスクの一覧を取得できるかテスト.
     *
     * @return void
     */
    public function test_can_get_tasks()
    {
        // 認証ユーザーの作成
        $user = User::factory()->create();
        Sanctum::actingAs($user); // 認証済みとしてAPIをテスト

        // ダミータスクを作成
        Task::factory()->create([
            'task_name' => 'Test Task',
            'content' => 'This is a test task',
            'project' => '0'
        ]);

        // GETリクエストを送信してタスクリストを取得
        $response = $this->getJson('/api/tasks/0');

        // ステータスコード200を期待
        $response->assertStatus(200);

        // JSONの構造を確認 (data キーを削除)
        $response->assertJsonStructure([
            '*' => [
                'task_id',
                'task_name',
                'content',
                'created_at',
                'updated_at',
            ]
        ]);
    }

    /**
     * タスクを作成できるかテスト.
     *
     * @return void
     */
    public function test_can_create_task()
    {
        // 認証ユーザーの作成
        $user_id = 1;
        $user = User::factory()->create([
            'id' => $user_id,
            'project' => 1
        ]);
        Sanctum::actingAs($user);

        // POSTリクエストでタスクを作成
        $response = $this->postJson("/api/tasks/{$user_id}", [
            'task_name' => 'New Task',
            'content' => 'Task description',
            'priority' => 1,
            'created_by' => 'admin',
            'updated_by' => 'admin',
            'update_count' => 0,
        ]);

        // ステータスコード201を期待
        $response->assertStatus(201);

        // データベースに新しいタスクがあるか確認
        $this->assertDatabaseHas('tb_task', [
            'task_name' => 'New Task',
            'content' => 'Task description',
        ]);
    }

    /**
     * タスクを更新できるかテスト.
     *
     * @return void
     */
    public function test_can_update_task()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // ダミータスクを作成
        $task = Task::factory()->create([
            'task_name' => 'Old Task',
            'content' => 'Old description',
        ]);

        // PUTリクエストでタスクを更新
        $response = $this->putJson("/api/tasks/{$task->task_id}", [
            'task_name' => 'Updated Task',
            'content' => 'Updated description',
            'updated_by' => 'admin', // 必要なフィールドを追加
        ]);

        // ステータスコード200を期待
        $response->assertStatus(200);

        // データベースが更新されたことを確認
        $this->assertDatabaseHas('tb_task', [
            'task_id' => $task->task_id,
            'task_name' => 'Updated Task',
            'content' => 'Updated description',
        ]);
    }

    /**
     * タスクを削除できるかテスト.
     *
     * @return void
     */
    public function test_can_delete_task()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // ダミータスクを作成
        $task = Task::factory()->create([
            'task_name' => 'Task to be deleted',
        ]);

        // DELETEリクエストでタスクを削除
        $response = $this->deleteJson("/api/tasks/{$task->task_id}");

        // ステータスコード204を期待
        $response->assertStatus(204);

        // データベースからタスクが削除されたことを確認
        $this->assertDatabaseMissing('tb_task', [
            'task_id' => $task->task_id,
        ]);
    }
}
