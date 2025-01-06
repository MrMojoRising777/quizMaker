@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="card-title">
                <input type="text" name="title" value="{{ $quiz->title }}">
            </div>

            <form action="{{ route('quiz.store', ['quiz' => $quiz->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row" id="render-content">
                    @include('quiz.partials.tabs')
                </div>

                <button type="submit" class="btn waves-effect waves-light">{{ __("Save") }}</button>
            </form>
        </div>
    </div>
    @include('modals.quiz.newRoundModal')
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#newRoundForm').on('submit', function (e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('quiz.createRound', ['quiz' => $quiz->id]) }}",
                    method: "POST",
                    data: formData,
                    success: function (response) {
                        $('#newRoundModal').modal('close');

                        $('#render-content').html(response.html);
                        $('ul.tabs').tabs(); // Reinitialize tabs
                    }
                });
            });
        });
    </script>
@endpush
