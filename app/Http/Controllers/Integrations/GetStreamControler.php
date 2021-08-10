<?php

namespace App\Http\Controllers\Integrations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class GetStreamControler extends Controller
{
    //

    public function index()
    {

        $client = new \GetStream\Stream\Client('9j8mussvhwku', 'k3hbcktzjskde4nenef9kvpud23rh6vbza6gzuc3s8spcv37h6aybkuv4z6ft3zd');

        // For the feed group 'user' and user id 'eric' get the feed
        $ericFeed = $client->feed('user', 'eim');

        // Add the activity to the feed
        $data = [
            "actor" => "SU:eim",
            "verb" => "like",
            "object" => "3",
            "tweet" => "Hello EIM",
        ];

        $data = $ericFeed->addActivity($data);
        dd($data);
        dd($ericFeed);
    }

    public function generateToken() {
        $client = new \GetStream\Stream\Client('9j8mussvhwku', 'k3hbcktzjskde4nenef9kvpud23rh6vbza6gzuc3s8spcv37h6aybkuv4z6ft3zd');
        $userToken = $client->createUserSessionToken(auth()->user()->id);

        dd($userToken);
    }
}
