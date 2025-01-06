@extends('layouts.app')

@section('content')
    <div class="section">
        <div class="card">
            <div class="card-content">
                @can('create quiz')
                    <div class="row">
                        <div class="col s12">
                            <div class="card off-white-bg">
                                <div class="card-content">
                                    @include('quiz.includes.table')
                                </div>
                                <div class="card-action">
                                    <a href="#newQuizModal" class="btn blue-bg modal-trigger">{{ __("Create quiz") }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

                @if(auth()->user()->hasRole('Player'))
                    <div class="row">
                        <div class="col s12 m6">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-title">{{ __("Personal") }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col s12 m6">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-title">{{ __("Personal") }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @can('play quiz')

                @endcan
            </div>
        </div>
    </div>

    @include('modals.quiz.newQuizModal')
@endsection
