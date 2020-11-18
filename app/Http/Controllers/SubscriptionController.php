<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Channel;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Channel $channel)
    {
        return $channel->subscriptions()->create([
            'user_id' => auth()->user()->id
        ]);
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Channel $channel, Subscription $subscription)
    {
        $subscription->delete();
    }
}
