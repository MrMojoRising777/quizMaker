<div id="newQuizModal" class="modal">
    <div class="modal-content">
        <h4>{{ __("Give the quiz a name") }}</h4>
        <form action="{{ route('quiz.create') }}">
            <div class="row">
                <div class="col s12">
                    <input type="text" name="name" placeholder="{{ __("Name") }}">
                </div>

                <div class="col s12">
                    <textarea id="textarea1" name="description" class="materialize-textarea" placeholder="{{ __("Description") }}"></textarea>
                </div>
            </div>

            <button class="btn blue-bg">{{ __('Create') }}</button>
        </form>

    </div>
    <div class="modal-footer">
        <a href="javascript:void(0)" class="waves-effect btn-flat black-text">{{ __("Close") }}</a>
    </div>
</div>
