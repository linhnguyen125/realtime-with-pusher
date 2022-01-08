<?php

namespace App\Http\Controllers\Api;

use App\Events\Message;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $message = [
            'username' => 'Linh',
            'content' => 'Hi'
        ];
        return $message;
    }

    public function store(Request $request)
    {
        $message = $request->message;
        broadcast(new Message($message));
        return $message;
    }
}
