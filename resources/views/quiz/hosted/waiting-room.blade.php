@extends('layouts.app')

@section('content')
    <waiting-room
        :quiz-data='@json($quiz)'
        :user-data="{{ json_encode(Auth::user()) }}">

    </waiting-room>
@endsection
