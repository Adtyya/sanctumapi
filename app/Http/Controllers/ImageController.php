<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\CloudinaryStorage;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $image  = $request->file('image');
        $result = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName()); 
        Image::create(['image' => $result]);
        return response()->json(['msg' => 'success']);
    }

    public function update(Request $request, Image $image)
    {
        $file   = $request->file('image');
        $result = CloudinaryStorage::replace($image->image, $file->getRealPath(), $file->getClientOriginalName());
        $image->update(['image' => $result]);
        return redirect()->route('images.index')->withSuccess('berhasil upload');
    }

    public function destroy(Image $image)
    {   
        CloudinaryStorage::delete($image->image);
        $image->delete();
        return redirect()->route('images.index')->withSuccess('berhasil hapus');;
    }
}
