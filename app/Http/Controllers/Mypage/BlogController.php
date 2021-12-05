<?php

namespace App\Http\Controllers\Mypage;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        //自分のブログ一覧のみを表示する
        // $blogs = Blog::where('user_id', Auth::user()->id)->get();
        $blogs = $request->user()->blogs;
        return view('mypage.index', compact('blogs'));
    }

    public function create()
    {
        return view('mypage.blog.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'is_open' => ['nullable'],
        ]);

        $data['is_open'] = $request->boolean('is_open');

        $blog = $request->user()->blogs()->create($data);

        return redirect(route('mypage.blog.edit', $blog))->with('message', '新規登録しました');
    }

    public function edit(Blog $blog, Request $request)
    {
        //自分のブログに限定する
        if ($request->user()->isNot($blog->user)) {
            abort(403);
        }
        $data = old() ?: $blog;
        return view('mypage.blog.edit', compact('data'));
    }
}
