<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('tenant.posts.index', [
            'posts' => Post::cursor(),
        ]);
    }

    public function show(Post $post)
    {
        return view('tenant.posts.show', [
            'post' => $post,
        ]);
    }

    public function create()
    {
        return view('tenant.posts.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);

        /** @var User $user */
        $user = auth()->user();

        $post = $user->posts()->create($validated);

        return redirect(route('tenant.posts.show', [
            'post' => $post,
        ]));
    }
}
