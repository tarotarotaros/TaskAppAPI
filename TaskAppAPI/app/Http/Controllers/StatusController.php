<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

class StatusController extends Controller
{
    // 全てのステータスを取得
    public function index()
    {
        return response()->json(Status::all());
    }

    // ステータスを1つ登録
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable',
        ]);

        $status = Status::create([
            'name' => $validated['name'],
        ]);

        return response()->json($status, 201);
    }

    // ステータスを1つ削除
    public function destroy($id)
    {
        $status = Status::find($id);

        if (!$status) {
            return response()->json(['message' => 'Status not found'], 404);
        }

        $status->delete();

        return response()->json(['message' => 'Status deleted'], 200);
    }

    // ステータス更新
    public function update(Request $request, $id)
    {
        $status = Status::findOrFail($id);

        // バリデーション
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable',
            'updated_by' => 'required',
        ]);


        // ステータス更新
        $status->update(array_merge($validated, [
            'update_date' => now(),
            'update_count' => $status->update_count + 1,
        ]));

        return response()->json($status);
    }
}
