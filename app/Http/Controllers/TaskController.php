<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    // タスク一覧取得
    public function index($projectId)
    {
        return Task::where('project', $projectId)->get();
    }

    // ユーザーIDでフィルターしたタスク一覧取得
    public function indexWhereUser($userid)
    {
        return Task::where('assignee', $userid)->get();
    }

    // タスク登録
    public function store(Request $request, $userid)
    {
        // バリデーション
        $validated = $request->validate([
            'task_name' => 'required',
            'content' => 'nullable',
            'priority' => 'nullable|integer',
            'deadline' => 'nullable|date',
            'start' => 'nullable|date',
            'end' => 'nullable|date',
            'project' => 'nullable|integer',
            'status' => 'nullable|integer',
            'miled' => 'nullable|integer',
            'milestone' => 'nullable',
            'assignee' => 'nullable|integer',
            'created_by' => 'required',
            'updated_by' => 'required',
        ]);

        // 'deadline' が存在する場合、フォーマットを修正
        if (isset($validated['deadline'])) {
            $validated['deadline'] = Carbon::parse($validated['deadline'])->format('Y-m-d H:i:s');
        }

        if (isset($validated['start'])) {
            $validated['start'] = Carbon::parse($validated['start'])->format('Y-m-d H:i:s');
        }

        if (isset($validated['end'])) {
            $validated['end'] = Carbon::parse($validated['end'])->format('Y-m-d H:i:s');
        }

        $user = User::findOrFail($userid);

        // 新しいタスクを作成
        $task = Task::create(array_merge($validated, [
            'project' => $user->project,
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
            'task_name' => 'nullable',
            'content' => 'nullable',
            'priority' => 'nullable|integer',
            'deadline' => 'nullable|date',
            'start' => 'nullable|date',
            'end' => 'nullable|date',
            'project' => 'nullable|integer',
            'status' => 'nullable|integer',
            'miled' => 'nullable|integer',
            'milestone' => 'nullable',
            'assignee' => 'nullable|integer',
            'updated_by' => 'required',
        ]);

        // 'deadline' が存在する場合、フォーマットを修正
        if (isset($validated['deadline'])) {
            $validated['deadline'] = Carbon::parse($validated['deadline'])->format('Y-m-d H:i:s');
        }

        if (isset($validated['start'])) {
            $validated['start'] = Carbon::parse($validated['start'])->format('Y-m-d H:i:s');
        }

        if (isset($validated['end'])) {
            $validated['end'] = Carbon::parse($validated['end'])->format('Y-m-d H:i:s');
        }

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

        return response()->noContent(); // 204ステータスを返す
    }
}
