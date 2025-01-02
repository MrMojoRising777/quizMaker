@extends('layouts.app')

@section('content')
    <div id="waiting-room">
        <h1>Waiting Room</h1>
        <p>Host: {{ $hostedQuiz->host->name }}</p>
        <h3>Players:</h3>
        <ul id="player-list">
            @foreach ($hostedQuiz->players as $player)
                <li>{{ $player->user->name }}</li>
            @endforeach
        </ul>

        @if (auth()->id() === $hostedQuiz->host_id)
            <button id="start-quiz" onclick="startQuiz()">Start Quiz</button>
        @else
            <p>Waiting for the host to start the quiz...</p>
        @endif
    </div>

@endsection
