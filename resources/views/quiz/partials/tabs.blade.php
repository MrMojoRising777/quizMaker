<div class="col s12">
    <ul class="tabs red-bg">
        @foreach($quiz->rounds as $round)
            <li class="tab col s2">
                <a href="#tab-{{ $round->dev_slug }}" class="yellow-text">{{ $round->title }}</a>
            </li>
        @endforeach

        <li class="tab col s2">
            <a href="#newRoundModal" class="modal-trigger text-yellow">Add</a>
        </li>
    </ul>
</div>

@foreach($quiz->rounds as $round)
    <div id="tab-{{ $round->dev_slug }}" class="col s12">
        @include('quiz.partials.' . $round->type, ['round' => $round])
    </div>
@endforeach
