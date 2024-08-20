@extends('layouts.app')
@push('style')

@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="alert alert-success successAlert mb-3" role="alert" style="display: none">
                    <span>From successfully saved</span>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="my-1">
                            <div class="form-group">
                                <label for="form_name">Form Name</label>
                                <input type="text" class="form-control" id="form_name" name="form_name" placeholder="Enter form name">
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="build-wrap"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

    <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
    <script>
        jQuery($ => {
            const fbEditor = document.getElementById("build-wrap");

            var fields = [{
                label: 'Logo',
                type: 'image',
                subtype: 'img',
                icon: '🖼️'
            }];

            // Define custom templates
            var templates = {
                image: function(fieldData) {
                    let srcVal = fieldData.value ? fieldData.value : 'https://via.placeholder.com/150';

                    return {
                        field: '<div class="' + fieldData.className + '">' +
                            '<img src="' + srcVal + '" alt="Logo" id="' + fieldData.name + '" style="max-width: 100%;"/>' +
                            '</div>',
                        onRender: function() {
                        }
                    };
                }
            };


            let formBuilder = $(fbEditor).formBuilder();


            $(document).on("click", ".save-template", function () {
                let formName = $("#form_name").val();
                if (formName === "") {
                    alert("Please enter form name");
                    return false;
                }
                let confirmText = confirm("Are you sure you want to save this form?");
                if (!confirmText) {
                    return false;
                }
                const formHtml = formBuilder.actions.getData('xml');

                var formData = formHtml,
                    formRenderOpts = {
                        dataType: 'xml',
                        formData: formData
                    };

                var renderedForm = $('<div>');
                renderedForm.formRender(formRenderOpts);

               let html = renderedForm.html();
               let json = formBuilder.actions.getData('json');

                $.ajax({
                    url: "{{ route('save-form') }}",
                    type: "POST",
                    data: {
                        html: html,
                        json: json,
                        name: formName,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        console.log(response);
                        $(".successAlert").show();
                        formBuilder.actions.clearFields();
                        $("#form_name").val('');

                        setTimeout(function () {
                            $(".successAlert").hide();
                        }, 3000);
                    }
                });

            });

        });

    </script>

@endpush
