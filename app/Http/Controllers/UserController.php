<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use \Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    // ユーザー一覧
    public function index()
    {
        return response()->json(User::all());
    }

    public function register(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // ユーザーを作成
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json('User registration completed', Response::HTTP_OK);
    }


    public function login(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // ユーザー認証
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::where('email', $request->email)->first();
            $user->tokens()->delete();
            $token = $user->createToken("login:user{$user->id}")->plainTextToken;

            // 生成したトークンをapi_tokenカラムに保存
            $user->api_token = $token;
            $user->save();

            return response()->json(['token' => $token], Response::HTTP_OK);
        }

        return response()->json('User unauthorized', Response::HTTP_UNAUTHORIZED);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'ログアウトしました。'], 200);
    }

    public function updateProjectId(Request $request, $id)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'project' => ['required', 'integer', 'exists:tb_project,id'], // project_idが存在するかチェック
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // ユーザーを取得
        $user = User::findOrFail($id);

        // projectを更新
        $user->update([
            'project' => $request->project,
        ]);

        return response()->json(['message' => 'Project ID updated successfully', 'project' => $user->project], Response::HTTP_OK);
    }

    public function checkPassword(Request $request, $id)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // ユーザーをIDで取得
        $user = User::find($id);

        // ユーザーが存在しない場合
        if (!$user) {
            return response()->json('User not found', Response::HTTP_NOT_FOUND);
        }

        // パスワードが一致するか確認
        if (Hash::check($request->password, $user->password)) {
            return response()->json('Password is correct', Response::HTTP_OK);
        }

        return response()->json('Password is incorrect', Response::HTTP_UNAUTHORIZED);
    }

    public function changePassword(Request $request, $id)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'], // new_password_confirmation を確認
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // ユーザーをIDで取得
        $user = User::find($id);

        if (!$user) {
            return response()->json('User not found', 404);
        }

        // 現在のパスワードが正しいか確認
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json('パスワードが正しくありません。', 401);
        }

        // 新しいパスワードを設定
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json('Password updated successfully', 200);
    }

    // プロジェクトを取得
    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function destroy($id)
    {
        // ユーザーをIDで取得
        $user = User::find($id);

        // ユーザーが存在しない場合
        if (!$user) {
            return response()->json('User not found', Response::HTTP_NOT_FOUND);
        }

        // ユーザーを削除
        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], Response::HTTP_OK);
    }


    // 更新
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        // バリデーション
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required',
            'updated_by' => 'required',
        ]);

        // パスワード確認
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json('パスワードが正しくありません。', 401);
        }

        // 更新
        $user->update(array_merge($validated, [
            'update_date' => now(),
            'update_count' => $user->update_count + 1,
        ]));

        return response()->json($user);
    }
}
