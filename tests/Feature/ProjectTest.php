<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_create_a_project()
    {
        // 認証ユーザーの作成
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $data = [
            'id' => 1,
            'name' => 'New Project',
            'is_complete' => false,
            'created_by' => 'user1',
            'updated_by' => 'user1',
            'update_count' => 0
        ];

        $this->postJson('/api/projects', $data)
            ->assertStatus(201);
    }

    #[Test]
    public function can_update_a_project()
    {
        // 認証ユーザーの作成
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $project = Project::factory()->create();

        $data = [
            'name' => 'Updated Project',
            'is_complete' => true,
            'updated_by' => 'user2',
            'update_count' => 1
        ];

        $this->putJson("/api/projects/{$project->id}", $data)
            ->assertStatus(200);
    }

    #[Test]
    public function can_delete_a_project()
    {
        // 認証ユーザーの作成
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $project = Project::factory()->create();

        $this->deleteJson("/api/projects/{$project->id}")
            ->assertStatus(204);
    }

    #[Test]
    public function it_can_get_a_project()
    {
        // 認証ユーザーの作成
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // プロジェクトを1つ作成
        $project = Project::factory()->create([
            'name' => 'Sample Project',
            'is_complete' => false,
            'created_by' => 'user1',
            'updated_by' => 'user1',
            'update_count' => 1
        ]);

        // 作成したプロジェクトを取得し、レスポンスが正しいか確認
        $this->getJson("/api/projects/{$project->id}")
            ->assertStatus(200)
            ->assertJson([
                'id' => $project->id,
                'name' => 'Sample Project',
                'is_complete' => false,
                'created_by' => 'user1',
                'updated_by' => 'user1',
                'update_count' => 1
            ]);
    }

    #[Test]
    public function it_can_get_all_projects()
    {
        // 認証ユーザーの作成
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // プロジェクト一覧を取得し、レスポンスが正しいか確認
        $this->getJson('/api/projects')
            ->assertStatus(200)
            ->assertJsonCount(1);
    }
}
