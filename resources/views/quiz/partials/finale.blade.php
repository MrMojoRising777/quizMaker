<div class="row">
    @for($i = 1; $i <= 4; $i++)
        <input type="text" placeholder="Wat weet je over {{ $i }}">
        @for($j = 1; $j <= 5; $j++)
            <input type="text" placeholder="Woord {{ $j }}">
        @endfor
    @endfor
</div>
