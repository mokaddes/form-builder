@extends('layouts.app')
@push('style')

@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4>{{ $assign->form->name ?? "Form $assign->form_id" }}</h4>
                            </div>
                            <div>
                                {{ $assign->user->name }}
                            </div>
                            <div>
                                <a href="{{ route('home') }}" class="btn btn-primary">Back</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('update-form', $assign->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $assign->user_id }}">
                            <input type="hidden" name="form_id" value="{{ $assign->form_id }}">
                            <div id="html_content"></div>
{{--                            {!! $assign->form->html_content !!}--}}

                            <div class="form-group mt-3 text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>

                        </form>

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
        let container = document.getElementById('html_content');
        let formData = {!! json_encode($assign->form->json_content) !!};
        var formRenderOpts = {
            formData,
            dataType: 'json'
        };

        $(container).formRender(formRenderOpts);
    </script>
@endpush
