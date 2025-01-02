<div class="row">
    @for($i = 1; $i <= 3; $i++)
        <input type="text" name="" placeholder="Woord {{ $i }}">
        @for($j = 1; $j <= 4; $j++)
            <input type="text" name="" placeholder="Hint {{ $j }}">
        @endfor
    @endfor
</div>
