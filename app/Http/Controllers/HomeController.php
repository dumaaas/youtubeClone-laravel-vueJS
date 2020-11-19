<?php

namespace App\Http\Controllers;
use App\Models\Channel;
use App\Models\Video;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $query = request()->search;
        $videos = collect();
        $channels = collect();

        if($query!=null){
            $videos = Video::where('title', 'LIKE', "%{$query}%")->orWhere('description', 'LIKE', "%{$query}%")->paginate(5);
            $channels = Channel::where('name', 'LIKE', "%{$query}%")->orWhere('description', 'LIKE', "%{$query}%")->paginate(5);
        }

        return view('home')->with([
            'videos' => $videos,
            'channels' => $channels
        ]);
    }
}
