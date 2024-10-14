<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // プロジェクト一覧を取得
    public function index()
    {
        return Project::all();
    }

    // プロジェクトを作成
    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // 新しいプロジェクトを作成
        $project = Project::create([
            'name' => $validated['name'],
            'created_by' => $request['created_by'],
            'updated_by' => $request['updated_by'],
            'created_at' => now(),
            'updated_at' => now(),
            'update_count' => 0,
        ]);

        return response()->json($project, 201);
    }

    // プロジェクトを取得
    public function show($id)
    {
        return Project::findOrFail($id);
    }

    // プロジェクトを更新
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        // バリデーション
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'updated_by' => 'required',
        ]);

        // 優先度更新
        $project->update(array_merge($validated, [
            'update_by' => now(),
            'update_count' => $project->update_count + 1,
        ]));

        return response()->json($project, 200);
    }

    // プロジェクトを削除
    public function destroy($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'project not found'], 404);
        }

        $project->delete();

        return response()->json(null, 204);
    }
}
