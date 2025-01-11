@extends('layouts.app')

@section('content')
    <player-screen :quiz-id="{{ $quiz->id }}"></player-screen>
@endsection
