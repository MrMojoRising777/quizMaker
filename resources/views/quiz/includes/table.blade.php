<table class="striped responsive-table">
    <thead>
    <tr>
        <th>Naam</th>
        <th>Rounds</th>
        <th>Times played</th>
        <th>Reviews</th>
        <th>Actions</th>
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
                <a class="light-blue-text host-quiz" href="javascript:void(0);" data-id="{{ $quiz->id }}"><i class="material-icons">cloud_upload</i></a>
                <a class="light-yellow-text modal-trigger" href="#reviewModal"><i class="material-icons">rate_review</i></a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4">No quizzes where found</td>
        </tr>
    @endforelse
    </tbody>
</table>

@include('modals.quiz.reviewModal')

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.delete-quiz').on('click', function () {
                const quizId = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
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
