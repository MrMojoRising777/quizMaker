@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="card-title">
                <input type="text" name="title" value="{{ $quiz->title }}">
            </div>

            <form action="{{ route('quiz.store', ['quiz' => $quiz->id]) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col s12">
                        <ul class="tabs">
                            <li class="tab col s2"><a href="#round1">3-6-9</a></li>
                            <li class="tab col s2"><a href="#round2">Open Deur</a></li>
                            <li class="tab col s2"><a href="#round3">Puzzel</a></li>
                            <li class="tab col s2"><a href="#round4">Galerij</a></li>
                            <li class="tab col s2"><a href="#round5">Collectieve Geheugen</a></li>
                            <li class="tab col s2"><a href="#round6">Finale</a></li>
                        </ul>
                    </div>

                    <div id="round1" class="col s12">
                        @include('quiz.partials.3-6-9')
                    </div>
                    <div id="round2" class="col s12">
                        @include('quiz.partials.open-deur')
                    </div>
                    <div id="round3" class="col s12">
                        @include('quiz.partials.puzzel')
                    </div>
                    <div id="round4" class="col s12">
                        Of Ingelijst
                        @include('quiz.partials.galerij')
                    </div>
                    <div id="round5" class="col s12">
                        @include('quiz.partials.collectief-geheugen')
                    </div>
                    <div id="round6" class="col s12">
                        @include('quiz.partials.finale')
                    </div>
                </div>

                <button type="submit" class="btn waves-effect waves-light">Submit</button>
            </form>
        </div>
    </div>
    @include('modals.quiz.newRoundModal')
@endsection
