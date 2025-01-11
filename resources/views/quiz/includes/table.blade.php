<table class="striped responsive-table">
    <thead>
    <tr>
        <th>{{ __("Name") }}</th>
        <th>{{ __("Rounds") }}</th>
        <th>{{ __("Times played") }}</th>
        <th>{{ __("Reviews") }}</th>
        <th>{{ __("Actions") }}</th>
    </tr>
    </thead>
    <tbody>
    @forelse($quizzes as $quiz)
        <tr>
            <td>{{ $quiz->title }}</td>
            <td>{{ $quiz->rounds->count() }}</td>
            <td>UD</td>
            <td>
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $quiz->averageRating())
                        ★
                    @else
                        ☆
                    @endif
                @endfor

                ({{ $quiz->reviews->count() }})
            </td>
            <td>
                <a class="orange-text" href="{{ route('quiz.show', ['quiz' => $quiz->id]) }}"><i class="material-icons">edit</i></a>
                <a class="red-text delete-quiz" href="javascript:void(0);" data-id="{{ $quiz->id }}"><i class="material-icons">delete</i></a>
                @if($quiz->isHostable())
                    <a class="light-blue-text host-quiz" href="javascript:void(0);" data-id="{{ $quiz->id }}"><i class="material-icons">cloud_upload</i></a>
                @endif
                <a class="light-yellow-text modal-trigger" href="#reviewModal"><i class="material-icons">rate_review</i></a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4">{{ __("No quizzes where found.") }}</td>
        </tr>
    @endforelse
    </tbody>
</table>

{{--@include('modals.quiz.reviewModal')--}}

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.host-quiz').on('click', function () {
                const quizId = $(this).data('id');

                // New window: players screen
                $.get('{{ route("quiz.hosted.waiting-room", ":id") }}'.replace(':id', quizId), function (response){
                    const playerScreenWindow = window.open('', 'PlayerScreen', 'width=800,height=600,resizable,scrollbars=yes,status=no');
                    playerScreenWindow.document.open();
                    playerScreenWindow.document.write(response.html);
                    playerScreenWindow.document.close();

                    // Same window: host screen
                    window.location.href = '{{ route("quiz.hosted.waiting-room", ":id") }}'.replace(':id', quizId);
                });
            });

            $('.delete-quiz').on('click', function () {
                const quizId = $(this).data('id');

                Swal.fire({
                    title: '{{ __("Are you sure?") }}',
                    text: "{{ __("This action cannot be undone!") }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '{{ __("Yes, delete it!") }}',
                    cancelButtonText: '{{ __("Cancel") }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route("quiz.delete", ":id") }}'.replace(':id', quizId),
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                showToast('success', response.message);
                                window.location.href = response.redirect;
                            },
                        });
                    }
                });
            });
        });
    </script>
@endpush
