@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="content">
            @include('quiz.includes.table')
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('tr[data-href]').click(function () {
                window.location = $(this).data('href');
            });
        });
    </script>
@endpush
