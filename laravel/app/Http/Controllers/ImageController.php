<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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

    

}
