@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Game Play</h1>
        <p>Lobby ID: {{ $lobbyId }}</p>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <form method="POST" action="{{ route('game.saveWord', ['lobbyId' => $lobbyId]) }}">
    @csrf


    <div class="form-group">
        <label for="player_word">Your Word:</label>
        <input type="text" name="player_word" id="player_word" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Save Word</button>
</form>

    </div>
@endsection
