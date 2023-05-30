<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game; // Replace 'Game' with your actual model

class GameController extends Controller
{
    public function play($lobbyId)
    {
        // Retrieve the two words for the specified game
        $words = Game::where('game_id', $lobbyId)->get(['word'])->pluck('word')->toArray();
    
        // Shuffle the characters within both words
        foreach ($words as &$word) {
            if (strlen($word) >= 6) {
                $wordCharacters = str_split($word);
                shuffle($wordCharacters);
                $word = implode('', $wordCharacters);
            }
        }
    
        // Pass the shuffled words to the view
        return view('game.play', ['lobbyId' => $lobbyId, 'words' => $words]);
    }
    
    public function guessWord(Request $request, $lobbyId)
    {
        $guessedWord = $request->input('guessed_word');
    
        // Retrieve the opponent's word from the database
        $opponentWord = Game::where('game_id', $lobbyId)
            ->where('player_id', '!=', auth()->user()->id) // Exclude the player's own word
            ->value('word');
    
        if (!$opponentWord) {
            return redirect()->back()->with('error', 'The opponent word is not available.');
        }
    
        if ($guessedWord === $opponentWord) {
            // Word matches the opponent's word, the player wins
            return redirect()->back()->with('success', 'Congratulations! You won the game.');
        }
    
        // Word doesn't match
        return redirect()->back()->with('error', 'Sorry, the word does not match.');
    }
    
    public function saveWord(Request $request, $lobbyId)
    {
        $playerId = auth()->user()->id;
        
        // Check if the player has already submitted a word
        $existingWord = Game::where('game_id', $lobbyId)
            ->where('player_id', $playerId)
            ->exists();
        
        if ($existingWord) {
            return redirect()->back()->with('error', 'You have already submitted a word.');
        }
        
        $word = $request->input('player_word');
        
        // Save the word to the database
        $game = new Game();
        $game->game_id = $lobbyId;
        $game->word = $word;
        $game->player_id = $playerId;
        $game->save();
    
        return redirect()->back()->with('success', 'Word saved successfully.');
    }
    
    
    
    
}