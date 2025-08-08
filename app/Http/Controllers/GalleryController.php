<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function show(){
        $gallery = Gallery::all();
        return view('admin.gallery',compact('gallery'));
    }
    public function create(){
        return view('admin.gallery.add-gallery');
    }
    public function store(Request $request)
    {
        $request->validate([
            
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048|required',
            'title'=> 'required',
            'description'=> 'required',
        ]);

        // Initialize image name as null
        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('gallery'), $imageName);
        }

        Gallery::create([
            
            'image' => $imageName, // Will be null if no image uploaded
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('gallery.show')->with('success', 'Image successfully added!');
    }

    public function destroy(Gallery $gallery){
        $gallery->delete();
        return redirect()->route('gallery.show')->with('success','image successfully deleted!');
    }

    public function index(){
        $gallery = Gallery::all();
        return view('users.member.gallery',compact('gallery'));
    }
}
