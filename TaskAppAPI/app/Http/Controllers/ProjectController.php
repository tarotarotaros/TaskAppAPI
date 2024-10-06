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
        $project = Project::create($request->all());
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
        $project->update($request->all());
        return response()->json($project, 200);
    }

    // プロジェクトを削除
    public function destroy($id)
    {
        Project::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
