<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Validator;

use App\Models\Chats;
use App\Models\Sms;

class SmsController extends Controller
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
     * Add Sms.
     *
     * @return json
     */
    public function addSms(Request $request)
    {
        $validator = validator::make($request->all(), [
            'sms_text' => 'required',
            'user_id' => 'required',
            'chat_id' => 'required',
        ]);

        if ($validator->fails()) {
            echo json_encode(['status' => 'fail']);die;
        }

        $sms = new Sms();
        $sms_id = $sms->addSms([
                'chat_id' => $request->input('chat_id'),
                'user_id' => $request->input('user_id'),
                'text'    => $request->input('sms_text'),
            ]);

        echo json_encode(['status' => 'success', 'sms_id' => $sms_id]);die;
    }

    /**
     * Add Sms.
     *
     * @return json
     */
    public function getNewest(Request $request)
    {
        $chats = new Chats();
        $chat = $chats->select(['id' => $request->input('chat_id')]);

        $sms = new Sms();
        $allSms = $sms->smsWithUser([
                ['sms.id', '>', $request->input('last_sms_id')],
                ['chat_id','=', $request->input('chat_id')],
            ]);

        if(empty($chat)){
            echo json_encode(['status' => 'fail']);die;
        }else{
            $chat = $chat[0];
        }

        if($chat->users_online){
            $data = json_decode($chat->users_online,true);
        }else{
            $date = [];
        }

        $data[$request->input('user_id')] = ['count' => 1, 'date' => time()];

        foreach ($data as $key => $value) {
            if(time() - $value['date'] > 3){
                unset($data[$key]);
                continue;
            }
        }

        $chats->updateChat(['id' => $chat->id],['users_online' => json_encode($data)]);

        echo json_encode(['status' => 'success', 'allSms' => $allSms, 'users_online' => $data, 'count' => count($data)]);die;
    }
}
