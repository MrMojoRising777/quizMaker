<ul class="collection">
    @php $questions = $round?->questions; @endphp

    @for ($i = 1; $i <= 15; $i++)
        @php $question = $questions[$i - 1] ?? null; @endphp

        <li class="collection-item">
            <input
                placeholder="{{ __("Question") }} {{ $i }}"
                value="{{ $question?->text ?? '' }}"
                type="text"
                name="rounds[{{ $round->id }}][questions][{{ $i }}]">

            @php $answers = $question?->answers ?? []; @endphp

            @forelse($answers as $answer)
                <input
                    placeholder="{{ __("Answer") }} {{ $i }}"
                    value="{{ $answer->text ?? '' }}"
                    type="text"
                    name="rounds[{{ $round->id }}][answers][{{ $i }}]">
            @empty
                <input
                    placeholder="{{ __("Answer") }} {{ $i }}"
                    type="text"
                    name="rounds[{{ $round->id }}][answers][{{ $i }}]">
            @endforelse
        </li>
    @endfor
</ul>
