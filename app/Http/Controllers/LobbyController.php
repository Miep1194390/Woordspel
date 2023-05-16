<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lobby;
use Illuminate\Support\Facades\Auth;

class LobbyController extends Controller
{
    public function index()
    {
        $lobbies = Lobby::all();

        return view('lobby.index', compact('lobbies'));
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
        ]);

        // Assuming the user who creates the lobby should automatically join it
        $user = Auth::user();
        $user->lobbies()->attach($lobby->id);

        return redirect()->route('lobby.index')->with('success', 'Lobby created successfully.');
    }
}
