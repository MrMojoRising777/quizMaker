<div class="row">
    <div class="col s12 center-align valign-wrapper">
        <a href="javascript:void(0)" id="toggleImg" class="btn mr-5 mt-5">
            <i class="material-icons">image</i> Img
        </a>
        <a href="javascript:void(0)" id="toggleTxt" class="btn mt-5">
            <i class="material-icons">short_text</i> Txt
        </a>
    </div>

    <div id="imgSection" class="displayNone">
        @for($i = 1; $i <= 4; $i++)
            <div class="col s5 push-s2">
{{--                <a href="">--}}
{{--                    <img src="https://freeiconshop.com/wp-content/uploads/edd/upload-cloud-outline-filled.png" alt="" style="width: 60%">--}}
{{--                </a>--}}

                <label for="imgInput{{ $i }}" style="cursor: pointer;">
                    <img id="imgPlaceholder{{ $i }}"
                         src="https://freeiconshop.com/wp-content/uploads/edd/upload-cloud-outline-filled.png"
                         alt="Upload placeholder"
                         style="width: 60%; border: 1px solid #ccc;">
                </label>
                <input type="file" id="imgInput{{ $i }}" accept="image/*" style="display: none;">
            </div>
        @endfor
    </div>

    <div id="txtSection" class="displayNone">
        @for($i = 1; $i <= 4; $i++)
            <div class="col s5 push-s2">
                <input type="text" name="textInputs[]" placeholder="Thema {{ $i }}">
            </div>
        @endfor
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            const imgSection = $('#imgSection');
            const txtSection = $('#txtSection');

            // Toggle sections
            $('#toggleImg').on('click', function () {
                imgSection.show();
                txtSection.hide();
            });

            $('#toggleTxt').on('click', function () {
                txtSection.show();
                imgSection.hide();
            });

            // Handle image uploads
            for (let i = 1; i <= 4; i++) {
                $(`#imgInput${i}`).on('change', function (event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            $(`#imgPlaceholder${i}`).attr('src', e.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
@endpush
