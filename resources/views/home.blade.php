<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Droow.nl | Dashboard</title>
</head>
<body>

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Gebruikers</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Status</th>
                    <th>Opties</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>
                            @if ($user->hasReceivedFriendRequest())
                                Vriendenverzoek verzonden    
                            @elseif ($user->hasSentFriendRequest())
                                Vriendenverzoek ontvangen
                            @endif
                        </td>
                        <td>
                            @if ($user->hasSentFriendRequest())
                                @if ($user->hasAcceptedFriendRequest())
                                    Vrienden geworden
                                @else
                                    @if (!$user->acceptedFriends->contains(Auth::user()))
                                        <form action="{{ route('friend-request.accept', $user) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Accepteer</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('friend-request.reject', $user) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Verwijder</button>
                                    </form>
                                @endif
                            @elseif ($user->hasReceivedFriendRequest())
                                
                            @else
                                <form action="{{ route('friend-request.send', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Vriendenverzoek verzenden</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2>Vrienden:</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Naam</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($friends as $friend)
                    <tr>
                        <td>{{ $friend->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
    
</body>
</html>


