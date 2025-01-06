<div id="reviewModal" class="modal">
    <form action="{{ route('reviews.store', ['quiz' => $quiz->id]) }}" method="POST">
        @csrf

        <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
        <div class="modal-content">
            <h4>{{ __("Leave a review") }}</h4>

            <label for="rating">{{ __("Rating") }}:</label>
            <Rating name="rating" class="orange-text light-yellow-on-hover"></Rating>

            <label for="review">{{ __("Review") }}:</label>
            <textarea name="review" id="review" rows="4" class="materialize-textarea"></textarea>
        </div>

        <div class="modal-footer">
            <a href="javascript:void(0);" class="modal-close btn-flat black-text">{{ __("Close") }}</a>
            <button type="submit" class="btn-flat black-text">{{ __("Submit Review") }}</button>
        </div>
    </form>
</div>
