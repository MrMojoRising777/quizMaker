<div class="row mt-5">
    @php $questions = $round?->questions; @endphp

    @for($i = 1; $i <= 4; $i++)
        @php $question = $questions[$i - 1] ?? null; @endphp

        <div class="col s5 push-s1 mb-5">
            <label for="upload{{ $i }}" class="pointer">
                <img id="preview{{ $i }}"
                     src="{{ isset($question->file_path) ? asset('storage/' . $question->file_path) : 'https://freeiconshop.com/wp-content/uploads/edd/upload-cloud-outline-filled.png' }}"
                     alt="Placeholder"
                     class="w-100"/>
            </label>
            <input type="file"
                id="upload{{ $i }}"
                name="rounds[{{ $round->id }}][questions][{{ $i }}]"
                accept="image/*"
                class="displayNone"
                onchange="previewImage(this, 'preview{{ $i }}')">

            <input type="text"
                placeholder="{{ __("Caption or Question") }} {{ $i }}"
                @if(isset($question->text)) value="{{ $question->text }}" @endif
                name="rounds[{{ $round->id }}][questions][{{ $i }}][text]">

            @php $answers = $question?->answers ?? []; @endphp
{{--            @for($j = 1; $j <= 5; $j++)--}}
{{--                @forelse($answers as $answer)--}}
{{--                    <input type="text"--}}
{{--                        placeholder="Antwoord {{ $i }}"--}}
{{--                        value="{{ $answer->text ?? '' }}"--}}
{{--                        name="rounds[{{ $round->id }}][answers][{{ $i }}][]">--}}
{{--                @empty--}}
{{--                    <input type="text"--}}
{{--                        placeholder="Photo {{ $i }} Woord {{ $j }}"--}}
{{--                        name="rounds[{{ $round->id }}][answers][{{ $i }}][]">--}}
{{--                @endforelse--}}
{{--            @endfor--}}

            @for($j = 1; $j <= 5; $j++)
                <input type="text"
                       placeholder="{{ __("Image") }} {{ $i }} {{ __("Word") }} {{ $j }}"
                       value="{{ $answers[$j - 1]->text ?? '' }}"
                       name="rounds[{{ $round->id }}][answers][{{ $i }}][]">
            @endfor
        </div>
    @endfor
</div>

@push('scripts')
    <script>
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById(previewId).src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
