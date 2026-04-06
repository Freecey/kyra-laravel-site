<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\PageView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminBlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with('featuredMedia')
            ->latest()
            ->paginate(20);

        $viewCounts = PageView::whereIn('path', $posts->map(fn($p) => '/blog/' . $p->slug))
            ->selectRaw('path, count(*) as total')
            ->groupBy('path')
            ->pluck('total', 'path');

        return view('admin.blog.index', compact('posts', 'viewCounts'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'                   => 'required|string|max:255',
            'slug'                    => 'nullable|string|max:255|unique:blog_posts,slug',
            'excerpt'                 => 'nullable|string|max:1000',
            'content'                 => 'required|string',
            'meta_description'        => 'nullable|string|max:255',
            'status'                  => 'required|in:draft,published',
            'featured_image_position' => 'nullable|in:top,top-center,center,center-bottom,bottom',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = BlogPost::generateSlug($data['title']);
        }

        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        $data['author_id'] = Auth::id();

        $post = BlogPost::create($data);

        return redirect()->route('admin.blog.edit', $post)
            ->with('success', 'Article créé.');
    }

    public function edit(BlogPost $post)
    {
        $post->load(['media', 'featuredMedia']);
        $viewCount = PageView::where('path', '/blog/' . $post->slug)->count();
        return view('admin.blog.edit', compact('post', 'viewCount'));
    }

    public function update(Request $request, BlogPost $post)
    {
        $data = $request->validate([
            'title'                   => 'required|string|max:255',
            'slug'                    => ['required', 'string', 'max:255', Rule::unique('blog_posts', 'slug')->ignore($post->id)],
            'excerpt'                 => 'nullable|string|max:1000',
            'content'                 => 'required|string',
            'meta_description'        => 'nullable|string|max:255',
            'status'                  => 'required|in:draft,published',
            'featured_image_position' => 'nullable|in:top,top-center,center,center-bottom,bottom',
        ]);

        if ($data['status'] === 'published' && !$post->published_at) {
            $data['published_at'] = now();
        }

        $post->update($data);

        return redirect()->route('admin.blog.edit', $post)
            ->with('success', 'Article mis à jour.');
    }

    public function publish(BlogPost $post)
    {
        $post->update([
            'status'       => 'published',
            'published_at' => $post->published_at ?? now(),
        ]);

        return back()->with('success', 'Article publié.');
    }

    public function unpublish(BlogPost $post)
    {
        $post->update(['status' => 'draft']);

        return back()->with('success', 'Article dépublié (brouillon).');
    }

    public function destroy(BlogPost $post)
    {
        // Delete all associated media files from disk
        foreach ($post->media as $media) {
            $media->deleteFile();
        }

        $post->delete();

        return redirect()->route('admin.blog.index')
            ->with('success', 'Article supprimé.');
    }
}
