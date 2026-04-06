<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\PostMedia;
use Illuminate\Http\Request;

class AdminBlogMediaController extends Controller
{
    public function store(Request $request, BlogPost $post)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,webp,gif,svg|max:10240',
            'alt'  => 'nullable|string|max:255',
        ]);

        $file     = $request->file('file');
        $filename = $file->getClientOriginalName();
        $path     = $file->storeAs('blog/' . $post->id, $filename, 'public');

        $media = PostMedia::create([
            'blog_post_id' => $post->id,
            'disk'         => 'public',
            'path'         => $path,
            'filename'     => $filename,
            'mime_type'    => $file->getMimeType(),
            'size'         => $file->getSize(),
            'alt'          => $request->input('alt'),
        ]);

        return back()->with('success', 'Média ajouté (ID: ' . $media->id . ').');
    }

    public function setFeatured(BlogPost $post, PostMedia $media)
    {
        abort_if($media->blog_post_id !== $post->id, 403);

        $post->update(['featured_media_id' => $media->id]);

        return back()->with('success', 'Image vedette définie.');
    }

    public function destroy(BlogPost $post, PostMedia $media)
    {
        abort_if($media->blog_post_id !== $post->id, 403);

        // Clear featured if this is the featured media
        if ($post->featured_media_id === $media->id) {
            $post->update(['featured_media_id' => null]);
        }

        $media->deleteFile();
        $media->delete();

        return back()->with('success', 'Média supprimé.');
    }
}
