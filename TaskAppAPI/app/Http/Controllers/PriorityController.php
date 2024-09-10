<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Priority;

class PriorityController extends Controller
{
    // 全ての優先度を取得
    public function index()
    {
        return response()->json(Priority::all());
    }

    // 優先度を1つ登録
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $priority = Priority::create([
            'name' => $validated['name'],
        ]);

        return response()->json($priority, 201);
    }

    // 優先度を1つ削除
    public function destroy($id)
    {
        $priority = Priority::find($id);

        if (!$priority) {
            return response()->json(['message' => 'Priority not found'], 404);
        }

        $priority->delete();

        return response()->json(['message' => 'Priority deleted'], 200);
    }
}
