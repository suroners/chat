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
            $allChat = $chats->selectAll();
        }else{
            $allChat = $chats->select(['type' => 0]);
        }

        $view = View::make('sidebar',['chats' => $allChat]);
        echo $view->render();
    }
}
