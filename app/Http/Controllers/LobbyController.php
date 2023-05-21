<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lobby;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LobbyController extends Controller
{
    public function index()
    {
        $lobbies = Lobby::all();
        $userLobbies = Auth::user()->lobbies;
    
        return view('lobby.index', compact('lobbies', 'userLobbies'));
    }
    

    public function join(Request $request)
    {
        $lobbyId = $request->input('lobby_id');
        $user = Auth::user();

        if ($user->lobbies()->where('id', $lobbyId)->exists()) {
            return redirect()->route('lobby.index')->with('error', 'Je bent al deelgenomen aan deze lobby.');
        }

        // Logic to join the lobby
        $user->lobbies()->attach($lobbyId);

        return redirect()->route('lobby.index')->with('success', 'Lobby gejoined.');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
    
        // Logic to create a lobby
        $lobby = Lobby::create([
            'name' => $request->input('name'),
            'creator_id' => auth()->user()->id, // Assign the creator's user ID
        ]);
    
        // Assuming the user who creates the lobby should automatically join it
        $user = Auth::user();
        $user->lobbies()->attach($lobby->id);
    
        return redirect()->route('lobby.index')->with('success', 'Lobby created successfully.');
    }
    

    public function leave(Request $request)
    {
        $lobbyId = $request->input('lobby_id');
        $lobby = Lobby::findOrFail($lobbyId);
        
        // Verwijder de huidige gebruiker uit de lobby
        $lobby->users()->detach(auth()->user());
    
        // Controleren of er nog spelers in de lobby zijn
        if ($lobby->users()->count() === 0) {
            // Verwijder de lobby als er geen spelers meer zijn
            $lobby->delete();
        }
    
        return redirect()->route('lobby.index')->with('success', 'Je hebt de lobby verlaten.');
    }

    
    public function start(Request $request)
    {
        $lobbyId = $request->input('lobby_id');
        $lobby = Lobby::findOrFail($lobbyId);
    
        // Check if the current user is the creator of the lobby
        if ($lobby->user && $lobby->user->id !== auth()->user()->id) {
            return redirect()->route('lobby.index')->with('error', 'Only the lobby creator can start the lobby.');
        }
    
        // Check if the lobby has the maximum number of players
        if ($lobby->users->count() !== 2) {
            return redirect()->route('lobby.index')->with('error', 'The lobby is not full yet.');
        }
    
        // Logic to start the lobby and redirect players to a new page
        $lobby->status = 'active'; // Assuming 'active' represents a started lobby
        $lobby->save();
    
        // Redirect the players to a new page (adjust the route and parameters based on your application)
        $players = $lobby->users;
        foreach ($players as $player) {
            Redirect::to(route('game.play', ['lobbyId' => $lobbyId]))->with('success', 'Lobby started.')->send();
        }
    }
    
    
    
    
    
}
