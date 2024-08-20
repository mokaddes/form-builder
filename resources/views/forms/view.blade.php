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


                        @foreach(json_decode($formData->form_data, true) as $field)
                            @php
                                $name = $field['name'] ?? '';
                                $type = $field['type'] ?? '';
                                $value = $allValues[$name] ?? '';
                            @endphp
                            <div class="form-group">
                                @if($type === 'header')
                                    {{-- Render Header --}}
                                    <p><strong>{{ $field['label'] }}</strong></p>

                                @elseif($type === 'autocomplete' || $type === 'select')
                                    {{-- Render Autocomplete or Select --}}
                                    <p>{{ $field['label'] }}:
                                        <strong>
                                            @php
                                                $selectedOption = collect($field['values'])->firstWhere('value', $value);
                                                echo $selectedOption['label'] ?? $value;
                                            @endphp
                                        </strong>
                                    </p>

                                @elseif($type === 'checkbox-group')
                                    {{-- Render Checkbox Group --}}
                                    <p>{{ $field['label'] }}:
                                        <strong>
                                            @php
                                                $selectedCheckboxes = collect($field['values'])
                                                    ->whereIn('value', (array)$value)
                                                    ->pluck('label')
                                                    ->implode(', ');
                                                echo $selectedCheckboxes;
                                            @endphp
                                        </strong>
                                    </p>

                                @elseif($type === 'radio-group')
                                    {{-- Render Radio Group --}}
                                    <p>{{ $field['label'] }}:
                                        <strong>
                                            @php
                                                $selectedRadio = collect($field['values'])->firstWhere('value', $value);
                                                echo $selectedRadio['label'] ?? $value;
                                            @endphp
                                        </strong>
                                    </p>

                                @elseif($type === 'text' || $type === 'textarea' || $type === 'date' || $type === 'number')
                                    {{-- Render Text, Text Area, Date, or Number Field --}}
                                    <p>{{ $field['label'] }}: <strong>{{ $value }}</strong></p>

                                @elseif($type === 'file')
                                    {{-- Render File --}}
                                    <p>{{ $field['label'] }}:
                                        <strong>
                                            <a href="{{ asset($value) }}" target="_blank">View File</a>
                                        </strong>
                                    </p>

                                @elseif($type === 'button')
                                    {{-- Render Button --}}
                                    <p><strong>{{ $field['label'] }}</strong></p>

                                @elseif($type === 'paragraph')
                                    {{-- Render Paragraph --}}
                                    <p><strong>{{ $field['label'] }}</strong></p>
                                @endif
                            </div>
                        @endforeach




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
