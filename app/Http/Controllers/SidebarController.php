<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Chats;

class SidebarController extends Controller
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
     * Show the application sidebar.
     *
     * @return 
     */
    public function getSidebar()
    {
        $chats = new Chats();

        if(!Auth::guest()){
            $allChat = $chats->select([['is_only_slug','<>',1]]);
            $onlySlugChats = $chats->select(['is_only_slug' => 1, 'user_id' => Auth::user()->id]);
        }else{
            $allChat = $chats->select(['type' => 0,'is_only_slug' => 0]);
            $onlySlugChats = [];
        }

        $view = View::make('sidebar',['chats' => $allChat, 'onlySlugChats' => $onlySlugChats]);
        echo $view->render();
    }
}
