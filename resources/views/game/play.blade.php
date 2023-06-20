<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="https://images.pexels.com/photos/262333/pexels-photo-262333.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1">
        <title>Droow.nl | Woord Twister {{ $lobbyId }}</title>
    </head>

<body>
@extends('layouts.app')

@section('content')
    <div class="container">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(count($words) >= 2)
            <p>Woord Speler 1: {{ $words[0] }}</p>
            <p>Woord Speler 2: {{ $words[1] }}</p>
        @elseif(count($words) === 1)
            <p>Player 1 word: {{ $words[0] }}</p>
            <p>Wachten tot uw tegenstander zijn woord invoert.</p>
        @else
            <p>Wachten tot beide spelers hun woorden hebben ingevoerd.</p>
        @endif

        @if(count($words) < 2)
            <form method="POST" action="{{ route('game.saveWord', $lobbyId) }}">
                @csrf
                <div class="form-group">
                    <label for="player_word">Jouw woord:</label>
                    <input type="text" name="player_word" id="player_word" class="form-control">
                    <input type="hidden" name="player_id" value="{{ auth()->user()->id }}">
                </div>
                <button type="submit" class="btn btn-primary">Verzenden</button>
            </form>
        @endif

        @if(count($words) === 2)
            <hr>
            <h3>Raad uw tegenstander zijn woord!</h3>

            <form method="POST" action="{{ route('game.guessWord', $lobbyId) }}">
                @csrf
                <div class="form-group">
                    <label for="guessed_word">Raad het woord van uw tegenstander!</label>
                    <input type="text" name="guessed_word" id="guessed_word" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Gokje wagen</button>
            </form>
        @endif
    </div>
@endsection
</body>
</html>