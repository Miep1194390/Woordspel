<?php

use App\Models\Player;

// ...

public function saveWord(Request $request, $lobbyId)
{
    $word = $request->input('player_word');

    // Get the authenticated player's ID
    $playerId = auth()->id();

    // Check if the game already has two words
    $game = Game::where('game_id', $lobbyId)->count();
    if ($game >= 2) {
        return redirect()->back()->with('error', 'The maximum number of words for this game has been reached.');
    }

    // Save the word to the database with the player ID
    $game = new Game();
    $game->game_id = $lobbyId;
    $game->player_id = $playerId; // Assign the player ID to player_id column
    $game->word = $word;
    $game->save();

    return redirect()->back()->with('success', 'Word saved successfully.');
}
