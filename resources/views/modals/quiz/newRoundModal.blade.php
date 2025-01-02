<div class="modal" id="newRoundModal">
    <div class="modal-content">
        <h4>Add new round</h4>
        <form id="newRoundForm">
            @csrf
            <div class="row">
                <div class="col s12">
                    <input type="text" name="title" placeholder="Round title">

                    <select name="type" class="browser-default">
                        @foreach(\App\Models\Round::getRoundTypes() as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn waves-effect waves-light">Submit</button>
        </form>
    </div>
</div>
