@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="img-bg">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Lobbies</div>

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if ($lobbies->count() > 0)
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Naam</th>
                                            <th>Spelers</th>
                                            <th>Opties</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lobbies as $lobby)
                                            <tr>
                                                <td>{{ $lobby->name }}</td>
                                                <td>{{ $lobby->users->count() }}</td>
                                                <td>
                                                    <form class="d-inline" action="{{ route('lobby.join') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="lobby_id" value="{{ $lobby->id }}">
                                                        <button type="submit" class="btn btn-primary">Join</button>
                                                    </form>
                                                    <form class="d-inline" method="POST" action="{{ route('lobby.leave') }}">
                                                        @csrf
                                                        <input type="hidden" name="lobby_id" value="{{ $lobby->id }}">
                                                        <button type="submit" class="btn btn-danger">Verlaat Lobby</button>
                                                    </form>
                                                    @if ($lobby->users->count() === 2)
                                                    <form class="d-inline" method="POST" action="{{ route('lobby.start') }}">
                                                    @csrf
                                                    <input type="hidden" name="lobby_id" value="{{ $lobby->id }}">
                                                        <button type="submit" class="btn btn-success">Game</button>
                                                     </form>
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>Geen lobbies beschikbaar.</p>
                            @endif
                            <hr>

                            <h4>Lobby aanmaken</h4>
                            <form action="{{ route('lobby.create') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="lobby_name">Lobby Naam</label>
                                    <input type="text" name="name" id="lobby_name" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary">Aanmaken</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
