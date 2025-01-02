<div id="reviewModal" class="modal">
    <form action="{{ route('reviews.store', ['quiz' => $quiz->id]) }}" method="POST">
        @csrf

        <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
        <div class="modal-content">
            <h4>Leave a review</h4>

            <label for="rating">Rating:</label>
            <select name="rating" id="rating" class="browser-default" required>
                @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                @endfor
            </select>
            <label for="review">Review:</label>
            <textarea name="review" id="review" rows="4"></textarea>
        </div>

        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
            <button type="submit">Submit Review</button>
        </div>
    </form>
</div>
