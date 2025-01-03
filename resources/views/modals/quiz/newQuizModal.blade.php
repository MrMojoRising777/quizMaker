<div id="newQuizModal" class="modal">
    <div class="modal-content">
        <h4>Geef de quiz een naam</h4>
        <form action="{{ route('quiz.create') }}">
            <div class="row">
                <div class="col s12">
                    <input type="text" name="name" placeholder="Naam">
                </div>

                <div class="col s12">
                    <textarea id="textarea1" name="description" class="materialize-textarea" placeholder="Omschrijving"></textarea>
                </div>
            </div>

            <button class="btn blue-bg">Aanmaken</button>
        </form>

    </div>
    <div class="modal-footer">
        <a href="javascript:void(0)" class="waves-effect btn-flat black-text">sluiten</a>
    </div>
</div>
