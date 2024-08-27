<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        return Test::all();
    }

    public function store(Request $request)
    {
        $testResult = Test::create($request->all());
        return response()->json($testResult, 201);
    }

    public function show($id)
    {
        return Test::find($id);
    }

    public function update(Request $request, $id)
    {
        $testResult = Test::findOrFail($id);
        $testResult->update($request->all());
        return response()->json($testResult, 200);
    }

    public function destroy($id)
    {
        Test::destroy($id);
        return response()->json(null, 204);
    }
}
