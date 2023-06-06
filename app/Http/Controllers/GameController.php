<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
    public function play($lobbyId)
    {
        // De 2 woorden ontvangen voor die specifeke game die de 2 spelers hadden ingevoerd
        $words = Game::where('game_id', $lobbyId)->get(['word'])->pluck('word')->toArray();
    
        // Beide woorden shufflen
        foreach ($words as &$word) {
                $wordCharacters = str_split($word);
                shuffle($wordCharacters);
                $word = implode('', $wordCharacters);
            }
    
        // De 2 geshuffelde woorden sturen naar de view
        return view('game.play', ['lobbyId' => $lobbyId, 'words' => $words]);
    }
    
    public function guessWord(Request $request, $lobbyId)
    {
        $guessedWord = $request->input('guessed_word');
    
        // Woord ontvangen van de tegenstander via me db
        $opponentWord = Game::where('game_id', $lobbyId)
        // Hij checkt via != (id van huidige speler) dus dan weet je dat het de tegenstander zijn woord is
            ->where('player_id', '!=', auth()->user()->id)
            ->value('word');
    
        if (!$opponentWord) {
            return redirect()->back()->with('error', 'Het woord van de tegenderstander is nog niet beschikbaar.');
        }
    
        // Checkt of het woord van de tegenstander hetzelfde is als de input die de speler geeft.
        if ($guessedWord === $opponentWord) {
            return redirect()->back()->with('success', 'Gefeliciteerd je hebt gewonnen!');
        }
        // Als het woord niet overeen komt
        return redirect()->back()->with('error', 'Helaas, het woord komt niet overeen');
    }
    
    public function saveWord(Request $request, $lobbyId)
    {
        $playerId = auth()->user()->id;
        
        // Checkt of de player al een woord heeft ingevuld zodat er niet meerdere woorden van 1 speler komtt.
        $existingWord = Game::where('game_id', $lobbyId)
            ->where('player_id', $playerId)
            ->exists();
        
        if ($existingWord) {
            return redirect()->back()->with('error', 'You have already submitted a word.');
        }
        
        $word = $request->input('player_word');
        
        // Sla de worden op naar me db
        $game = new Game();
        $game->game_id = $lobbyId;
        $game->word = $word;
        $game->player_id = $playerId;
        $game->save();
    
        return redirect()->back()->with('success', 'Word saved successfully.');
    }
    
    
    
    
}