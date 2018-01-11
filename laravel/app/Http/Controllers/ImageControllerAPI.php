<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use Auth;

class ImageControllerAPI extends Controller
{
	public function all(){
        $activeIds = Image::where('active', 1)->get(['id']);
        return $activeIds;
    }  

    public function getImage($id){
        $imgSrc = Image::findorfail($id);
        return $activeIds;
    }
}
