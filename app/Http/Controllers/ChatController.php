<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\ChatRequest;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Models\Chats;
use App\Models\Sms;
use App\Models\User;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => [
            'chat',
            'socketChat',
        ]]);
    }

    /**
     * Show the application create Chat form.
     *
     * @return \Illuminate\Http\Response
     */
    public function createChat()
    {
        $chats = new Chats();
        return view('chat.createChat');
    }

    /**
     * Show the application add chat in db.
     *
     * @return \Illuminate\Http\Response
     */
    public function addChat( ChatRequest $request)
    {
        $name = $request->input('name');
        $slug = $request->input('slug');
        $is_private = ($request->input('is_private'))?$request->input('is_private'):0;
        $is_only_slug = ($request->input('is_only_slug'))?$request->input('is_only_slug'):0;

        $file = array('image' => Input::file('image'));
        if (Input::file('image')->isValid()) {
            $destinationPath = base_path() . '/public/assets/images';
            $extension = Input::file('image')->getClientOriginalExtension();
            $fileName = rand(11111,99999).time().'.'.$extension;
            Input::file('image')->move($destinationPath, $fileName);
        }

        $chats = new Chats();
        $chats->addChat([
                'name'          => $name,
                'slug'          => $slug,
                'type'          => $is_private,
                'is_only_slug'  => $is_only_slug,
                'image_name'    => $fileName,
                'user_id'       => Auth::user()->id
            ]);

        return Redirect::to('createChat');
    }

    /**
     * Show Chat.
     *
     * @return \Illuminate\Http\Response
     */
    public function chat($slug)
    {
        $chats = new Chats();
        $chat = $chats->selectChatBySlug($slug);

        if($chat){
            $sms = new Sms();

            if(!Auth::guest() || !$chat->type){
                $allSms = $sms->smsWithUser(['chat_id' => $chat->id]);

                return view('chat.chat',[
                                'allSms' => $allSms,
                                'lastSmsId' => end($allSms)?end($allSms)->id:0,
                                'chat' => $chat,
                                'user' => (Auth::user())? Auth::user() : []
                            ]);
            }
        }

        return Redirect::to('/');
    }

    /**
     * Show Chat.
     *
     * @return \Illuminate\Http\Response
     */
    public function socketChat($slug)
    {
        $chats = new Chats();
        $chat = $chats->selectChatBySlug($slug);

        if($chat){
            $sms = new Sms();

            if(!Auth::guest() || !$chat->type){
                $allSms = $sms->smsWithUser(['chat_id' => $chat->id]);

                return view('chat.chatSocket',[
                                'allSms' => $allSms,
                                'lastSmsId' => end($allSms)?end($allSms)->id:0,
                                'chat' => $chat,
                                'user' => (Auth::user())? Auth::user() : []
                            ]);
            }
        }

        return Redirect::to('/');
    }

}
