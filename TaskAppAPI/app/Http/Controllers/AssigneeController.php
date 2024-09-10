<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignee;

class AssigneeController extends Controller
{
    // 全ての優先度を取得
    public function index()
    {
        return response()->json(Assignee::all());
    }

    // 優先度を1つ登録
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

    // 優先度を1つ削除
    public function destroy($id)
    {
        $assignee = Assignee::find($id);

        if (!$assignee) {
            return response()->json(['message' => 'Assignee not found'], 404);
        }

        $assignee->delete();

        return response()->json(['message' => 'Assignee deleted'], 200);
    }
}
