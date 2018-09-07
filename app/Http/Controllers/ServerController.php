<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\ChatRequest;
use App\Http\Controllers\Controller;

use Hoa\Websocket\Server AS WServer;
use Hoa\Socket\Server AS SServer;
use Hoa\Core\Event\Bucket;

use App\Models\Chats;
use App\Models\Sms;
use App\Models\User;

class ServerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Run Server.
     *
     * @return void
     */
    public function runServer()
    {
        set_time_limit(0);

        $server = new WServer(
            new SServer('tcp://127.0.0.1:8889',0)
        );

        //Manages the message event to get send data for each client using the broadcast method
        $server->on('message', function ( Bucket $bucket ) {
            $data = $bucket->getData();
            $message = json_decode($data['message']);
            $dataToSend = new \stdClass();
            $dataToSend->usersCount = 0;

            if(!isset($data['chats'])){
                $data['chats'] = [];
            }

            if($message->status == 'open'){
                $bucket->getSource()->getConnection()->getCurrentNode()->chat_id = $message->chat_id;
                $bucket->getSource()->getConnection()->getCurrentNode()->user_id = $message->user_id;
            }elseif($message->status == 'close'){

            }elseif($message->status == 'sms'){
                $sms = new Sms();
                $user = new User();

                $sms_id = $sms->addSms([
                        'chat_id' => $message->chat_id,
                        'user_id' => $message->user_id,
                        'text'    => $message->msg,
                    ]);

                $dataToSend->msg = $message->msg;

                $users = $user->select(['id' => $message->user_id]);
                if(!empty($users)){
                    $dataToSend->user = ['name' => $users[0]->name,'email' => $users[0]->email,'id' => $users[0]->id,];
                }else{
                    $dataToSend->user = [];
                }
            }

            $count = 0;
            foreach ($bucket->getSource()->getConnection()->getNodes() as $key => $value) {
                if($value->chat_id == $message->chat_id){
                    $dataToSend->usersCount++;
                }
            }

            foreach ($bucket->getSource()->getConnection()->getNodes() as $key => $value) {
                if($value->chat_id == $message->chat_id){
                    $bucket->getSource()->send(json_encode($dataToSend),$value);
                }
            }

            return;
        });

        //Execute the server
        $server->run();
    }

    /**
     * Cloase Server.
     *
     * @return void
     */
    public function closeServer()
    {

    }
}
