<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::published()
            ->with('featuredMedia')
            ->paginate(9);

        return view('blog.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = BlogPost::published()
            ->with(['featuredMedia', 'media', 'author'])
            ->where('slug', $slug)
            ->firstOrFail();

        $prev = BlogPost::published()
            ->where('published_at', '<', $post->published_at)
            ->first();

        $next = BlogPost::published()
            ->where('published_at', '>', $post->published_at)
            ->orderBy('published_at')
            ->first();

        return view('blog.show', compact('post', 'prev', 'next'));
    }
}
