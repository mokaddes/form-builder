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
                                <h4>{{ $formData->form->name ?? "Form $formData->form_id" }}</h4>
                            </div>
                            <div>
                                {{ $formData->user->name }}
                            </div>
                            <div>
                                <a href="{{ route('home') }}" class="btn btn-primary">Back</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">


                    <form action="{{ route('save-form') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @foreach(json_decode($formData->form_data, true) as $field)
                            @php
                                $name = $field['name'] ?? '';
                                $type = $field['type'] ?? '';
                                $value = $allValues[$name] ?? '';
                            @endphp
                            <div class="form-group">
                                @if($type === 'header')
                                    {{-- Render Header --}}
                                    <{{$field['subtype'] ?? 'h1'}}>{{ $field['label'] }}</{{$field['subtype'] ?? 'h1'}}>

                                @elseif($type === 'autocomplete' || $type === 'select')
                                    {{-- Render Autocomplete or Select --}}
                                    <label>{{ $field['label'] }}</label>
                                    <select name="{{ $name }}" class="{{ $field['className'] }}">
                                        @foreach($field['values'] as $option)
                                            <option value="{{ $option['value'] }}" {{ $option['selected'] ? 'selected' : '' }} {{ $value == $option['value'] ? 'selected' : ''  }} >
                                                {{ $option['label'] }}
                                            </option>
                                        @endforeach
                                    </select>

                                @elseif($type === 'checkbox-group')
                                    {{-- Render Checkbox Group --}}
                                    <label>{{ $field['label'] }}</label>
                                    @foreach($field['values'] as $checkbox)
                                        <div class="form-check">
                                            <input type="checkbox" name="{{ $name }}[]" value="{{ $checkbox['value'] }}"
                                                   class="form-check-input" {{ $value == $checkbox['value'] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ $checkbox['label'] }}</label>
                                        </div>
                                    @endforeach

                                @elseif($type === 'radio-group')
                                    {{-- Render Radio Group --}}
                                    <label>{{ $field['label'] }}</label>
                                    @foreach($field['values'] as $radio)
                                        <div class="form-check">
                                            <input type="radio" name="{{ $name }}" value="{{ $radio['value'] }}"
                                                   class="form-check-input" {{ $value == $radio['value'] ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ $radio['label'] }}</label>
                                        </div>
                                    @endforeach

                                @elseif($type === 'text')
                                    {{-- Render Text Field --}}
                                    <label>{{ $field['label'] }}</label>
                                    <input type="text" name="{{ $name }}" value="{{ $value }}" class="{{ $field['className'] }}"
                                           @if($field['required']) required @endif>

                                @elseif($type === 'textarea')
                                    {{-- Render Text Area --}}
                                    <label>{{ $field['label'] }}</label>
                                    <textarea name="{{ $name }}" class="{{ $field['className'] }}">{{ $value }}</textarea>

                                @elseif($type === 'date')
                                    {{-- Render Date Field --}}
                                    <label>{{ $field['label'] }}</label>
                                    <input type="date" name="{{ $name }}" value="{{ $value }}" class="{{ $field['className'] }}">

                                @elseif($type === 'file')
                                    {{-- Render File Upload --}}
                                    <label>{{ $field['label'] }} [<a href="{{ asset($value) }}">View File</a>] </label>
                                    <input type="file" name="{{ $name }}" class="{{ $field['className'] }}">

                                @elseif($type === 'number')
                                    {{-- Render Number Input --}}
                                    <label>{{ $field['label'] }}</label>
                                    <input type="number" name="{{ $name }}" value="{{ $value }}" class="{{ $field['className'] }}">

                                @elseif($type === 'button')
                                    {{-- Render Button --}}
                                    <button type="button" class="{{ $field['className'] }}">{{ $field['label'] }}</button>

                                @elseif($type === 'paragraph')
                                    {{-- Render Paragraph or Canvas (this would depend on your subtype) --}}
                                    @if($field['subtype'] === 'canvas')
                                        <canvas>{{ $field['label'] }}</canvas>
                                    @elseif($field['subtype'] === 'blockquote')
                                        <blockquote>{{ $field['label'] }}</blockquote>
                                    @elseif($field['subtype'] === 'p')
                                        <p>{{ $field['label'] }}</p>
                                    @elseif($field['subtype'] === 'address')
                                        <address>{{ $field['label'] }}</address>
                                    @elseif($field['subtype'] === 'output')
                                        <output>{{ $field['label'] }}</output>
                                    @endif
                                @endif
                            </div>
                        @endforeach

                        <div class="form-group text-center">
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

    <script !src="">
        $(document).ready(function () {
            $("#saveForm").submit(function (e) {
                e.preventDefault();
                let formHtml = $(".html-content").html();
                var formData = new FormData(this);
                formData.append('html_content', formHtml);
                console.log(formData);
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        console.log(data);
                        $(".successAlert").show();
                        setTimeout(function () {
                            $(".successAlert").hide();
                        }, 3000);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
        });
    </script>

@endpush
