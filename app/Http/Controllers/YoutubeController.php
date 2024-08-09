<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class YoutubeController extends Controller
{
    public function list()
    {
        $videos = Video::all();
        return view("app.video", compact('videos'));
    }
    public function preview(Video $video)
    {
        return view('app.preview',compact('video'));
    }
}
