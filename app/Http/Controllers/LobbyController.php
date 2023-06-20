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
        // Pakt alle lobbys van database en checkt welke lobby van welke user is en returned daarnaa naar view.
        $lobbies = Lobby::all();
        $userLobbies = Auth::user()->lobbies;
        return view('lobby.index', compact('lobbies', 'userLobbies'));
    }
   
    public function join(Request $request)
    {
        $lobbyId = $request->input('lobby_id');
        $user = Auth::user();
        // Checkt of de user al in de lobby zit.
        if ($user->lobbies()->where('id', $lobbyId)->exists()) {
            return redirect()->route('lobby.index')->with('error', 'Je bent al deelgenomen aan deze lobby.');
        }

        // Attached de user aan de lobby via db.
        $user->lobbies()->attach($lobbyId);

        return redirect()->route('lobby.index')->with('success', 'Lobby gejoined.');
    }

    public function create(Request $request)
    {
        // Chekt of de naam van user niet leeg is en validate het.
        $this->validate($request, [
            'name' => 'required',
        ]);
    
        // Lobby aanmken
        $lobby = Lobby::create([
            'name' => $request->input('name'),
            // Geeft de user zijn id door naar de creator_id
            'creator_id' => auth()->user()->id, 
        ]);
    
        // Na dat de lobby is gemaakt verstuurd die user naar zijn lobby gelijk.
        $user = Auth::user();
        $user->lobbies()->attach($lobby->id);
    
        return redirect()->route('lobby.index')->with('success', 'Lobby aangemaakt.');
    }
    
    public function leave(Request $request)
    {
        // Zoekt naar lobby met id derin en checkt of die bestaat anders dikke error (findorfail).   
        $lobbyId = $request->input('lobby_id');
        $lobby = Lobby::findOrFail($lobbyId);
        
        // Verwijdert de user uit lobby via detach
        $lobby->users()->detach(auth()->user());
    
        // Checkt of de users 0 is en verwijdert dan de lobby.
        if ($lobby->users()->count() === 0) {
            $lobby->delete();
        }
    
        return redirect()->route('lobby.index')->with('success', 'Je hebt de lobby verlaten.');
    }

    
    public function start(Request $request)
    {
        $lobbyId = $request->input('lobby_id');
        $lobby = Lobby::findOrFail($lobbyId);

        // Active status in de db betekent dat de lobby gestart is.
        $lobby->status = 'active'; 
        $lobby->save();
    
        // Redirect de 2 users naar nieuwe pagina.
        $players = $lobby->users;
        foreach ($players as $player) {
            Redirect::to(route('game.play', ['lobbyId' => $lobbyId]))->with('success', 'Lobby gestart.')->send();
        }
    }
    
    
    
    
    
}
