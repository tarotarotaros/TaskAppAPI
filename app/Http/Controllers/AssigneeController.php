<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignee;

class AssigneeController extends Controller
{
    // 全ての担当者を取得
    public function index()
    {
        return response()->json(Assignee::all());
    }

    // 担当者を1つ登録
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $assignee = Assignee::create([
            'name' => $validated['name'],
        ]);

        return response()->json($assignee, 201);
    }

    // 担当者を1つ削除
    public function destroy($id)
    {
        $assignee = Assignee::find($id);

        if (!$assignee) {
            return response()->json(['message' => 'Assignee not found'], 404);
        }

        $assignee->delete();

        return response()->json(['message' => 'Assignee deleted'], 200);
    }

    // 担当者更新
    public function update(Request $request, $id)
    {
        $assignee = Assignee::findOrFail($id);

        // バリデーション
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'updated_by' => 'required',
        ]);

        // 担当者更新
        $assignee->update(array_merge($validated, [
            'update_date' => now(),
            'update_count' => $assignee->update_count + 1,
        ]));

        return response()->json($assignee);
    }
}
