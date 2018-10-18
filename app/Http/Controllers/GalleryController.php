<?php

namespace App\Http\Controllers;

use App\Gallery;
use Illuminate\Http\Request;

session_start();

class GalleryController extends Controller
{
    public function index()
    {
        return view('gallery.view_gallery')->with('galleries', Gallery::get());
    }

    public function create()
    {
        return view('gallery.create_gallery');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gallery = new Gallery();
        $file = $request->file('image');
        if ($request->file('image') != null) {
            $destination_path = 'gallery/';
            $filename = str_random(6) . '_' . $file->getClientOriginalName();
            $file->move($destination_path, $filename);
            $gallery->image = $destination_path . $filename;
        }
        $gallery->text = request('text');
        $gallery->save();
        return redirect('gallery_master')->with('message', 'Gallery has been saved');
    }

    public function edit($id)
    {
        $gallery = Gallery::find($id);

        return view('gallery.edit_gallery')->with(['gallery' => $gallery]);
    }


    public function update($id, Request $request)
    {

        $gallery = Gallery::find($id);
        $file = $request->file('image');
        if ($request->file('image') != null) {
            $destination_path = 'gallery/';
            $filename = str_random(6) . '_' . $file->getClientOriginalName();
            $file->move($destination_path, $filename);
            $gallery->image = $destination_path . $filename;
        }
        $gallery->text = request('text');
        $gallery->save();
        return redirect('gallery_master')->with('message', 'Gallery has been updated...!');
    }

    public function destroy($id)
    {
        Gallery::find($id)->delete();
        return redirect('gallery_master')->with('message', 'Gallery has been deleted');
    }
}
