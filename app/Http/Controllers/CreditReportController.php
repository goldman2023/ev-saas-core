<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreditReportController extends Controller
{
    //

    public function store()
    {
//        $user_type = Product::findOrFail($request->product_id)->user->user_type;

//        $reciever

        $conversation = new Conversation;
        $conversation->sender_id = Auth::user()->id;
        $conversation->receiver_id = Product::findOrFail($request->product_id)->user->id;
        $conversation->title = $request->title;

        if ($conversation->save()) {
            $message = new Message;
            $message->conversation_id = $conversation->id;
            $message->user_id = Auth::user()->id;
            $message->message = $request->message;

            if ($message->save()) {
                $this->send_message_to_seller($conversation, $message, $user_type);
            }
        }

        flash(translate('Message has been send to seller'))->success();
        return back();
    }
}
