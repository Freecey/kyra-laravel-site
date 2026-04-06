<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\PostMedia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiPostMediaController extends Controller
{
    public function store(Request $request, BlogPost $post): JsonResponse
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

        return response()->json([
            'data'    => $this->mediaSummary($media),
            'message' => 'Média ajouté.',
        ], 201);
    }

    public function setFeatured(BlogPost $post, PostMedia $media): JsonResponse
    {
        abort_if($media->blog_post_id !== $post->id, 403, 'Média non associé à cet article.');

        $post->update(['featured_media_id' => $media->id]);

        return response()->json(['message' => 'Image vedette définie.']);
    }

    public function destroy(BlogPost $post, PostMedia $media): JsonResponse
    {
        abort_if($media->blog_post_id !== $post->id, 403, 'Média non associé à cet article.');

        if ($post->featured_media_id === $media->id) {
            $post->update(['featured_media_id' => null]);
        }

        $media->deleteFile();
        $media->delete();

        return response()->json(['message' => 'Média supprimé.']);
    }

    // ── Private helpers ───────────────────────────────────────────────────────

    private function mediaSummary(PostMedia $media): array
    {
        return [
            'id'        => $media->id,
            'filename'  => $media->filename,
            'url'       => $media->getUrl(),
            'mime_type' => $media->mime_type,
            'size'      => $media->size,
            'alt'       => $media->alt,
            'tag'       => '[media:' . $media->id . ']',
        ];
    }
}
