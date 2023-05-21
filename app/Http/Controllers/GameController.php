<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    public function play($lobbyId)
    {
        // Logic to start the game for the specified lobbyId
    
        return view('game.play', ['lobbyId' => $lobbyId]);
    }
    
}
