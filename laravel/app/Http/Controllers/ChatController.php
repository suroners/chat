<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\ChatRequest;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Hoa\Websocket\Server AS WServer;
use Hoa\Socket\Server AS SServer;
use Hoa\Core\Event\Bucket;

use App\Models\Chats;
use App\Models\Sms;

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
            'run',
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

        $file = array('image' => Input::file('image'));
        if (Input::file('image')->isValid()) {
            $destinationPath = base_path() . '/public/assets/images';
            $extension = Input::file('image')->getClientOriginalExtension();
            $fileName = rand(11111,99999).time().'.'.$extension;
            Input::file('image')->move($destinationPath, $fileName);
        }

        $chats = new Chats();
        $chats->addChat([
                'name'      => $name,
                'slug'      => $slug,
                'type'      => $is_private,
                'image_name'=> $fileName,
                'user_id'   => Auth::user()->id
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

                return view('chat.chat',['allSms' => $allSms,'chat' => $chat]);
            }
        }

        return Redirect::to('/');
    }

    /**
     * Run Chat.
     *
     * @return \Illuminate\Http\Response
     */
    public function runChat()
    {
        $server = new WServer(
            new SServer('tcp://127.0.0.1:8889')
        );

        $websocket->on('open', function ( Bucket $bucket ) {
          return;
        });

        //Manages the message event to get send data for each client using the broadcast method
        $server->on('message', function ( Bucket $bucket ) {
            $data = $bucket->getData();
            echo 'message: ', $data['message'], "\n";
            $bucket->getSource()->broadcast(json_encode($data['message']));
            return;
        });

        $websocket->on('close', function ( Bucket $bucket ) {
          return;
        });
        //Execute the server
        $server->run();
    }
}
