<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use Auth;
use Illuminate\Support\Facades\Storage;


class ImageControllerAPI extends Controller
{
	public function all(){
        $activeIds = Image::where('active', 1)->get();
        $paths = [];
        foreach ($activeIds as $img) {
        	array_push($paths,Storage::disk('local')->url('img/'.$img->path));
        }
        return $paths;
    }  

    public function getImage($id){
        $img = Image::findorfail($id);
        $imgSrc = Storage::disk('local')->url('img/'.$img->path) ;
        return $imgSrc;
    }

    public function getHidden(){
    	$img = Image::where('face', 'hidden')->first();
        $imgSrc = Storage::disk('local')->url('img/'.$img->path) ;
        return $imgSrc;
    }
}
