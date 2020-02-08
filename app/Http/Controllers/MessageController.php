<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'has.character']);
    }

    public function index(): View
    {
        return view('message.index');
    }
}
