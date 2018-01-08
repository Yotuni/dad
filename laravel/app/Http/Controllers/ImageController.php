<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Image;


class ImageController extends Controller
{
    public function shownFace()
    {
        $images = Image::where('face', 'tile')->get();
        return view('adminPanel.images.shownFace', compact('images'));
    }

    public function hiddenFace()
    {
    	$images = Image::where('face', 'hidden')->get();
        return view('adminPanel.images.hiddenFace', compact('images'));
    }

    public function activeShownFace(Image $image, Request $request)
    {
        $image->active = $request->active;
        $image->update();
        if($request->active == 1) {
            Session::flash('message', 'Image Activated!');
        } else {
            Session::flash('message', 'Image Disabled!');
        }
        return  redirect()->route('shownFace');
    }

    public function activeHiddenFace(Image $img, Request $request)
    {
        $img->active = $request->active;
        $img->update();
        if($request->active == 1) {
            Session::flash('message', 'Image Activated!');
        } else {
            Session::flash('message', 'Image Disabled!');
        }
        return  redirect()->route('hiddenFace');
    }

    public function create(Request $request) {
        $img = new Image();
        $image = $request->file('image');
        $resizedImage = Image::make($image)->resize(300, 300);
        $filename = $request->resizedImage->hashName();
        $path = 'img';
        //Storing image
        Storage::disk('public')->put($path . '/' , $resizedImage);
        //Get user
        $img->face = 'tile';
        $img->path = $filename;
        $img->active = 0;
        $img->save();
    }

}
