<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\PostMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class AdminBlogMediaController extends Controller
{
    public function store(Request $request, BlogPost $post)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,webp,gif,svg|max:10240',
            'alt'  => 'nullable|string|max:255',
        ]);

        $file     = $request->file('file');
        $slug     = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename = ($slug ?: Str::random(12)) . '_' . time() . '.webp';
        $dir      = 'blog/' . $post->id;
        $path     = $dir . '/' . $filename;

        $manager  = new ImageManager(new Driver());
        $encoded  = $manager->decode($file->getRealPath())
                            ->encode(new WebpEncoder(quality: 85));

        Storage::disk('public')->put($path, (string) $encoded);

        $media = PostMedia::create([
            'blog_post_id' => $post->id,
            'disk'         => 'public',
            'path'         => $path,
            'filename'     => $filename,
            'mime_type'    => 'image/webp',
            'size'         => Storage::disk('public')->size($path),
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
