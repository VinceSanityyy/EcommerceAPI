<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\ChatDetails;
use App\Enums\ChatStatus;
use Carbon\Carbon;
class ChatController extends Controller
{
   public function sendChatAdmin(Request $request){
        $chatExist = Chat::where('sender_id',\Auth::user()->id)->exists();
        if($chatExist){
            $chat =  Chat::where('sender_id',\Auth::user()->id)->first();
            $chat->time = Carbon::parse($request->timestamp);
            $chat->save();
        }else{
            $chat = new Chat;
            $chat->sender_id = \Auth::user()->id;
            $chat->reciever_id = $request->reciever_id;
            $chat->time = Carbon::parse($request->timestamp);
            $chat->status = ChatStatus::DELIVERED;
            $chat->save();
        }

            $chatDetails = new ChatDetails;
            $chatDetails->chat_id = $chat->id;
            $chatDetails->participantId = \Auth::user()->id;
            $chatDetails->content = $request->content;
            $chatDetails->type = 'text';
            $chatDetails->reciever_id = $chat->reciever_id;
            $chatDetails->uploaded = true;
            $chatDetails->viewed = false;
            $chatDetails->image = null;
            $chatDetails->dateTimeStamp = Carbon::parse($request->timestamp);
            $chatDetails->save();

        return response()->json('success');
   }

   public function sendChatCustomer(Request $request){
    $chatExist = Chat::where('sender_id',\Auth::user()->id)->exists();
    if($chatExist){
        $chat =  Chat::where('sender_id',\Auth::user()->id)->first();
        $chat->time = Carbon::parse($request->timestamp);
        $chat->save();
    }else{
        $chat = new Chat;
        $chat->sender_id = \Auth::user()->id;
        $chat->reciever_id = 1;
        $chat->time = Carbon::parse($request->timestamp);
        $chat->status = ChatStatus::DELIVERED;
        $chat->save();
    }

        $chatDetails = new ChatDetails;
        $chatDetails->chat_id = $chat->id;
        $chatDetails->participantId = \Auth::user()->id;
        $chatDetails->content = $request->content;
        $chatDetails->reciever_id = $chat->reciever_id;
        $chatDetails->type = 'text';
        $chatDetails->uploaded = true;
        $chatDetails->viewed = false;
        $chatDetails->image = null;
        $chatDetails->dateTimeStamp = Carbon::parse($request->timestamp);
        $chatDetails->save();

    return response()->json('success');
    }

    public function getMessageCustomer(){
        $chatDetails = ChatDetails::where('participantId',\Auth::user()->id)->orWhere('reciever_id',\Auth::user()->id)->get();
        return response()->json($chatDetails);
    }

    public function getMessageAdmin(Request $request){
       
        $chatDetails = ChatDetails::where('participantId',$request->reciever_id)->orWhere('reciever_id',$request->reciever_id)->get();
        return response()->json($chatDetails);
    }
    

    public function getAllMessages(){
        $messages = Chat::where('reciever_id',\Auth::user()->id);
        return response()->json($messages);
    }
}