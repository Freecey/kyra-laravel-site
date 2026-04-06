<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApiPostController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = BlogPost::with('featuredMedia')->latest();

        if ($request->query('status')) {
            $query->where('status', $request->query('status'));
        }

        $posts = $query->paginate($request->integer('per_page', 15));

        return response()->json([
            'data' => $posts->map(fn (BlogPost $p) => $this->postSummary($p)),
            'meta' => [
                'pagination' => [
                    'total'        => $posts->total(),
                    'per_page'     => $posts->perPage(),
                    'current_page' => $posts->currentPage(),
                    'last_page'    => $posts->lastPage(),
                ],
            ],
        ]);
    }

    public function show(BlogPost $post): JsonResponse
    {
        $post->load(['featuredMedia', 'media', 'author']);

        return response()->json([
            'data' => array_merge($this->postSummary($post), [
                'content'          => $post->content,
                'rendered_content' => $post->renderContent(),
                'media'            => $post->media->map(fn ($m) => $this->mediaSummary($m)),
                'author'           => $post->author ? ['id' => $post->author->id, 'name' => $post->author->name] : null,
            ]),
        ]);
    }

    public function store(Request $request): JsonResponse
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

        $data['author_id'] = $request->user()->id;

        $post = BlogPost::create($data);

        return response()->json([
            'data'    => $this->postSummary($post),
            'message' => 'Article créé.',
        ], 201);
    }

    public function update(Request $request, BlogPost $post): JsonResponse
    {
        $data = $request->validate([
            'title'                   => 'sometimes|required|string|max:255',
            'slug'                    => ['sometimes', 'required', 'string', 'max:255', Rule::unique('blog_posts', 'slug')->ignore($post->id)],
            'excerpt'                 => 'nullable|string|max:1000',
            'content'                 => 'sometimes|required|string',
            'meta_description'        => 'nullable|string|max:255',
            'status'                  => 'sometimes|required|in:draft,published',
            'featured_image_position' => 'nullable|in:top,top-center,center,center-bottom,bottom',
        ]);

        if (isset($data['status']) && $data['status'] === 'published' && !$post->published_at) {
            $data['published_at'] = now();
        }

        $post->update($data);

        return response()->json([
            'data'    => $this->postSummary($post->fresh(['featuredMedia'])),
            'message' => 'Article mis à jour.',
        ]);
    }

    public function destroy(BlogPost $post): JsonResponse
    {
        foreach ($post->media as $media) {
            $media->deleteFile();
        }
        $post->delete();

        return response()->json(['message' => 'Article supprimé.']);
    }

    public function publish(BlogPost $post): JsonResponse
    {
        $post->update([
            'status'       => 'published',
            'published_at' => $post->published_at ?? now(),
        ]);

        return response()->json(['data' => $this->postSummary($post), 'message' => 'Article publié.']);
    }

    public function unpublish(BlogPost $post): JsonResponse
    {
        $post->update(['status' => 'draft']);

        return response()->json(['data' => $this->postSummary($post), 'message' => 'Article dépublié.']);
    }

    // ── Private helpers ───────────────────────────────────────────────────────

    private function postSummary(BlogPost $post): array
    {
        return [
            'id'                       => $post->id,
            'title'                    => $post->title,
            'slug'                     => $post->slug,
            'excerpt'                  => $post->excerpt,
            'status'                   => $post->status,
            'published_at'             => $post->published_at?->toIso8601String(),
            'featured_image_url'       => $post->getFeaturedImageUrl(),
            'featured_image_position'  => $post->featured_image_position ?? 'center',
            'meta_description'         => $post->meta_description,
            'created_at'               => $post->created_at->toIso8601String(),
            'updated_at'               => $post->updated_at->toIso8601String(),
        ];
    }

    private function mediaSummary($media): array
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
