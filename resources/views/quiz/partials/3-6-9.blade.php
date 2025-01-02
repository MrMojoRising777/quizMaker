<ul class="collection">
    @php $questions = $round?->questions; @endphp

    @for ($i = 1; $i <= 15; $i++)
        @php $question = $questions[$i - 1] ?? null; @endphp

        <li class="collection-item">
            <input
                placeholder="Vraag {{ $i }}"
                value="{{ $question?->text ?? '' }}"
                type="text"
                name="rounds[{{ $round->id }}][questions][{{ $i }}]">

            @php $answers = $question?->answers ?? []; @endphp

            @forelse($answers as $answer)
                <input
                    placeholder="Antwoord {{ $i }}"
                    value="{{ $answer->text ?? '' }}"
                    type="text"
                    name="rounds[{{ $round->id }}][answers][{{ $i }}]">
            @empty
                <input
                    placeholder="Antwoord {{ $i }}"
                    type="text"
                    name="rounds[{{ $round->id }}][answers][{{ $i }}]">
            @endforelse
        </li>
    @endfor
</ul>
