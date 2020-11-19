<?php

namespace App\Http\Controllers;
use App\Http\Requests\Channels\UpdateChannelRequest;
use App\Models\Channel;

class ChannelController extends Controller
{

    public function __construct() {
        $this->middleware(['auth'])->only('update');
    }

    public function show(Channel $channel)
    {
        $videos = $channel->videos()->paginate(5);
        return view('channels.show', compact('channel', 'videos'));
    }

    public function update(UpdateChannelRequest $request, Channel $channel)
    {

        if($request->has('image')) {
            $channel->clearMediaCollection('images');

            $channel->addMedia($request->file('image'))->toMediaCollection('images');
        }

        $channel->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->back();
    }

    public function practicingGit()
    {
        $hej = 2;
    }

}
