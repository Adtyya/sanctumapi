<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $check = $request->validate([
            'title' => 'required|min:4|max:64',
            'body' => 'required|max:254',
            'image' => 'required',
            'category_id' => 'required',
            'user_id' => 'required'
        ]);
        $create = Post::create($check);
        return response()->json([
            'message' => 'success',
            'data' => $create
        ]);
    }

    public function show()
    {
        $data = Post::with('user','category')
                ->orderBy('created_at', 'desc');
        return PostResource::collection($data->paginate(8))->response();
    }

    public function detail($id)
    {
        $data = Post::find($id)
                ->with('user','category')
                ->first();
        return new PostResource($data);
    }
    
    public function delete($id)
    {
        $find = Post::find($id);
        if(!$find)
        {
            return response()->json([
                'message' => 'Post with id '.$id.' is not found!'
            ], 400);
        }
        $find->delete();
        return response()->json([
            'message' => 'Deleted successfully',
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|min:4|max:64',
            'body' => 'required|max:254',
            'image' => 'required',
            'category_id' => 'required',
            'user_id' => 'required'
        ]);
        $updatedData = Post::whereId($id)->update([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $request->image,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id
        ]);
        return response()->json([
            'success' => true,
            'message' => 'successfully updated'
        ]);
    }
}
