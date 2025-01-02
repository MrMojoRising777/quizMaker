@extends('layouts.app')

@section('content')
    <div class="section">
        <div class="card">
            <div class="card-content">
                <div class="row">
                    @can('create quiz')
                        <div class="col s12">
                            <div class="card bg-off-white">
                                <div class="card-content">
                                    @include('quiz.includes.table')
                                </div>
                                <div class="card-action">
                                    <a href="#newQuizModal" class="btn bg-blue modal-trigger">Quiz maken</a>
                                </div>
                            </div>
                        </div>
                    @endcan
                </div>
                <div class="row">
                    @can('edit quiz')
                        <div class="col s4">
                            <div class="btn">EDIT</div>
                        </div>
                    @endcan
                    @can('delete quiz')
                        <div class="col s4">
                            <div class="btn">DELETE</div>
                        </div>
                    @endcan
                    @can('host quiz')
                        <div class="col s4">
                            <div class="btn">HOST</div>
                        </div>
                    @endcan
                    @can('play quiz')
                        <div class="col s4">
                            <div class="btn">PLAY</div>
                        </div>
                    @endcan
                    @can('review quiz')
                        <div class="col s4">
                            <div class="btn">REVIEW</div>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    @include('modals.quiz.newQuizModal')
@endsection
