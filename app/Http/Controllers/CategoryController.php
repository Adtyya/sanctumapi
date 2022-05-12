<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $check = $request->validate([
            'name' => 'required|min:4|max:32',
        ]);
        $create = Category::create($check);
        return response()->json([
            'message' => 'success',
            'data' => $create
        ]);
    }

    public function show()
    {
        $data = Category::with('post')
                ->orderBy('created_at', 'desc')
                ->paginate(6);
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }
    
    public function delete($id)
    {
        $find = Category::find($id);
        if(!$find)
        {
            return response()->json([
                'message' => 'Category with id '.$id.' is not found!'
            ], 400);
        }
        $find->delete();
        $find->deleteRelatedPosts();
        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully',
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:4|max:64',
        ]);
        $updatedData = Category::whereId($id)->update([
            'name' => $request->title,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'successfully updated'
        ]);
    }
}
