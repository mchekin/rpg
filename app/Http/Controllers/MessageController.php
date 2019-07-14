<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'has.character']);
    }

    /**
     * @return Response
     */
    public function index()
    {
        return view('message.index');
    }
}
