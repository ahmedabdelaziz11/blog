<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Http\Traits\Api\ApiResponseTrait;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = auth()->user()->posts()->with(['tags'])->orderByDesc('pinned')->latest()->get();
        return $this->apiResponse(PostResource::collection($posts),'ok',200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();
        $data['cover_image'] = $this->storeCoverImage($request->file('cover_image'));
        $post = $user->posts()->create($data);

        $post->tags()->sync($request->input('tags', []));
        return $this->apiResponse(new PostResource($post->load(['tags'])),'created successfully',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = auth()->user();
        $post = $user->posts()->findOrFail($id);
        return $this->apiResponse(new PostResource($post->load(['tags'])),'ok',200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest  $request, string $id)
    {
        $user = auth()->user();
        $post = $user->posts()->findOrFail($id);
        $data = $request->validated();
        $data['cover_image'] = $this->storeCoverImage($request->file('cover_image'));
        $post->update($data);

        $post->tags()->sync($request->input('tags', []));

        return $this->apiResponse(new PostResource($post->load(['tags'])),'ok',200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = auth()->user();
        $post = $user->posts()->findOrFail($id);

        $post->delete();

        return $this->apiResponse(null,'Post deleted successfully',200);
    }

    public function deletedPosts()
    {
        $user = auth()->user();
        $deletedPosts = $user->posts()->onlyTrashed()->get();
        return $this->apiResponse(PostResource::collection($deletedPosts),'ok',200);
    }

    public function restore($id)
    {
        $user = auth()->user();
        $post = $user->posts()->onlyTrashed()->findOrFail($id);

        $post->restore();

        return $this->apiResponse(new PostResource($post),'ok',200);
    }

    private function storeCoverImage($file)
    {
        if ($file) {
            $imagePath = $file->store('public/cover_images');
            return 'storage/cover_images/' . basename($imagePath);
        }
        return null;
    }

}