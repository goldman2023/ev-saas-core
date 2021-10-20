<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class FeedController extends Controller
{
    //

    public function index()
    {
        $activities = Activity::orderBy('created_at', 'desc')->paginate(10);
        // $client = new \GetStream\Stream\Client('27bjdppvjh4u', 'dr8m8e8j6bzn2dnhm3fep3qf6xpuxtrt66z2hhv3fzzwgsnydfc3jv4w8tysh3ym');

        // Instantiate a new client, find your API keys in the dashboard.
        $client = new \GetStream\Stream\Client('27bjdppvjh4u', 'dr8m8e8j6bzn2dnhm3fep3qf6xpuxtrt66z2hhv3fzzwgsnydfc3jv4w8tysh3ym');

        // $userToken = $client->createUserToken(auth()->user()->id);

        // Instantiate a feed object
        $userFeed = $client->feed('user', auth()->user()->id);
        $response = $userFeed->getActivities();

        // no feed token is req'd when the Stream client was connected with an app secret
        $feed = $client->feed('user', auth()->user()->id);

        $feedToken = $client->createUserSessionToken((string)auth()->user()->id);
        $user =  $client->users()->update((string)auth()->user()->id, array('name' => auth()->user()->name));

        return view('frontend.feed.index', compact('activities', 'feedToken'));
    }
}
