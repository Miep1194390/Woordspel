@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Game Play</h1>
        <p>Lobby ID: {{ $lobbyId }}</p>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(count($words) >= 2)
            <p>Player 1 word: {{ $words[0] }}</p>
            <p>Player 2 word: {{ $words[1] }}</p>
        @elseif(count($words) === 1)
            <p>Player 1 word: {{ $words[0] }}</p>
            <p>Waiting for the other player to enter their word.</p>
        @else
            <p>Waiting for both players to enter their words.</p>
        @endif

        <form method="POST" action="{{ route('game.saveWord', $lobbyId) }}">
    @csrf
    <div class="form-group">
        <label for="player_word">Your Word:</label>
        <input type="text" name="player_word" id="player_word" class="form-control">
        <input type="hidden" name="player_id" value="{{ auth()->user()->id }}">
    </div>
    <button type="submit" class="btn btn-primary">Save Word</button>
</form>


        @if(count($words) === 2)
            <hr>
            <h3>Guess the Other Player's Word</h3>

            <form method="POST" action="{{ route('game.guessWord', $lobbyId) }}">
                @csrf
                <div class="form-group">
                    <label for="guessed_word">Guess the other player's word:</label>
                    <input type="text" name="guessed_word" id="guessed_word" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Guess</button>
            </form>
        @endif
    </div>
@endsection
