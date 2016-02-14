<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Predis\Client;
use Predis;

class ChatController extends Controller
{
    /**
     * Create a new DateController instance.
     *
     */
    public function __construct()
    {
        // redirect if not auth
        $this->middleware('auth', [
            'only' => [
                'getChat',
                'ajaxPostChat',
            ]
        ]);
    }

    /**
     * show the apply form
     */
    public function getChat()
    {
        return view('chat');
    }

    public function ajaxPostChat(Request $request)
    {
        Predis\Autoloader::register();

        try {
            $redis = new Client();
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $redis->publish('chat-channel', json_encode($request->input('msg')));
        return response()->json($request->input('msg'));
    }
}
