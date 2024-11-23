<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  // 会員一覧ページ
  public function index(Request $request)
  {
    $keyword = $request->input('keyword', '');

    // 検索ボックスのキーワードに基づいて、ユーザーをフィルタリング
    $users = User::when($keyword, function ($query, $keyword) {
      return $query->where('name', 'like', "%{$keyword}%")
        ->orWhere('furigana', 'like', "%{$keyword}%");
    })->paginate(10); // ページネーションを適用

    $total = $users->total(); // 取得したデータの総数

    // ビューにデータを渡す
    return view('admin.users.index', compact('users', 'keyword', 'total'));
  }

  // 会員詳細ページ
  public function show($id)
  {
    $user = User::findOrFail($id); // 指定したIDのユーザーを取得

    // ビューにデータを渡す
    return view('admin.users.show', compact('user'));
  }
}
