<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game; // Replace 'Game' with your actual model

class GameController extends Controller
{
    public function play($lobbyId)
    {
        // Logic to start the game for the specified lobbyId
        
        return view('game.play', ['lobbyId' => $lobbyId]);
    }
    
    public function saveWord(Request $request, $lobbyId)
    {
        $word = $request->input('player_word');
        
        // Check if the game already has two words
        $game = Game::where('game_id', $lobbyId)->count();
        if ($game >= 2) {
            return redirect()->back()->with('error', 'The maximum number of words for this game has been reached.');
        }
    
        // Save the word to the database
        $game = new Game(); // Replace 'Game' with your actual model
        $game->game_id = $lobbyId; // Assign lobbyId to game_id column
        $game->word = $word;
        $game->save();
    
        return redirect()->back()->with('success', 'Word saved successfully.');
    }
    
    
}