<?php

namespace App\Http\Controllers\Mypage;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogSaveRequest;
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

    public function store(BlogSaveRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('pict')) {
            $data['pict'] = $request->file('pict')->store('blogs', 'public');
        }

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
        return view('mypage.blog.edit', compact('blog', 'data'));
    }

    public function update(Blog $blog, BlogSaveRequest $request)
    {
        //自分のブログに限定する
        if ($request->user()->isNot($blog->user)) {
            abort(403);
        }
        $data = $request->validated();


        if ($request->hasFile('pict')) {
            //古い画像の削除
            $blog->deletePictFile();
            $data['pict'] = $request->file('pict')->store('blogs', 'public');
        }

        $blog->update($data);

        return redirect(route('mypage.blog.edit', $blog))->with('message', 'ブログを更新しました');
    }

    public function destroy(Blog $blog, Request $request)
    {
        if ($request->user()->isNot($blog->user)) {
            abort(403);
        }
        //画像と付属するコメントについてはイベントを使用して削除します。
        // Models/Blogを参照。
        // $blog->comments()->delete();
        $blog->delete();
        return redirect('mypage');
    }
}
