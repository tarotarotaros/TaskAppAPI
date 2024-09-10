<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

class StatusController extends Controller
{
    // 全ての優先度を取得
    public function index()
    {
        return response()->json(Status::all());
    }

    // 優先度を1つ登録
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $status = Status::create([
            'name' => $validated['name'],
        ]);

        return response()->json($status, 201);
    }

    // 優先度を1つ削除
    public function destroy($id)
    {
        $status = Status::find($id);

        if (!$status) {
            return response()->json(['message' => 'Status not found'], 404);
        }

        $status->delete();

        return response()->json(['message' => 'Status deleted'], 200);
    }
}
