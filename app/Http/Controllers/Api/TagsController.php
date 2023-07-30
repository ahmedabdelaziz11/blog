<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Http\Traits\Api\ApiResponseTrait;
use App\Models\Tag;

class TagsController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all();
        return $this->apiResponse(TagResource::collection($tags),'ok',200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request)
    {
        $tag = Tag::create($request->only('name'));
        return $this->apiResponse(new TagResource($tag),'Tag stored successfully',200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, Tag $tag)
    {
        $tag->update($request->only('name'));
        return $this->apiResponse(new TagResource($tag),'Tag updated successfully',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return $this->apiResponse(null,'Tag deleted successfully',200);

        return response()->json(['message' => 'Tag deleted successfully']);
    }
}
