<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    // タスク一覧取得
    public function index()
    {
        return Task::all();
    }

    // タスク登録
    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'task_name' => 'required',
            'content' => 'nullable',
            'priority' => 'nullable|integer',
            'deadline' => 'nullable|date',
            'project' => 'nullable|integer',
            'status' => 'nullable|integer',
            'miled' => 'nullable|integer',
            'milestone' => 'nullable',
            'manager' => 'nullable',
            'created_by' => 'required',
            'updated_by' => 'required',
        ]);

        // 新しいタスクを作成
        $task = Task::create(array_merge($validated, [
            'create_date' => now(),
            'update_date' => now(),
            'update_count' => 0,
        ]));

        return response()->json($task, 201);
    }

    // タスク更新
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        // バリデーション
        $validated = $request->validate([
            'task_name' => 'required',
            'content' => 'nullable',
            'priority' => 'nullable|integer',
            'deadline' => 'nullable|date',
            'project' => 'nullable|integer',
            'status' => 'nullable|integer',
            'miled' => 'nullable|integer',
            'milestone' => 'nullable',
            'manager' => 'nullable',
            'updated_by' => 'required',
        ]);

        // タスク更新
        $task->update(array_merge($validated, [
            'update_date' => now(),
            'update_count' => $task->update_count + 1,
        ]));

        return response()->json($task);
    }

    // タスク削除
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'タスクが削除されました']);
    }
}
