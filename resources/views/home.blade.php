@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('success'))
            <div class="alert alert-success successAlert mb-3" role="alert" >
                {{ session('success') }}
            </div>
            @endif
            <div class="card">
                <div class="card-header">{{ __('Forms') }}</div>

                <div class="card-body">
                    <div class="my-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Form Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($forms as $form)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $form->name ?? "Form $form->id" }}</td>
                                    <td>
                                        <a href="{{ route('form-builder', $form->id) }}" class="btn btn-primary">Edit</a>
                                        <a href="{{ route('delete-form', $form->id) }}" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-header">{{ __('Assign Form') }}</div>

                <div class="card-body">
                    <div class="my-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Form Name</th>
                                    <th scope="col">Assigned To</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignedForms as $assignedForm)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $assignedForm->form->name ?? "Form $assignedForm->form_id" }}</td>
                                    <td>{{ $assignedForm->user->name }}</td>
                                    <td>
                                        @if($assignedForm->formData)
                                            <a href="{{ route('edit-form', $assignedForm->formData->id) }}" class="btn btn-primary">Edit</a>
                                            <a href="{{ route('view-form', $assignedForm->formData->id) }}" class="btn btn-info">View</a>
                                        @else
                                            <a href="{{ route('fill-form', $assignedForm->id) }}" class="btn btn-primary">Add</a>
                                        @endif
                                        <a href="{{ route('delete-assign-form', $assignedForm->id) }}" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="my-3">
                        <form action="{{ route('assign-form') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="form_id">Form</label>
                                <select name="form_id" id="form_id" class="form-control">
                                    @foreach($forms as $form)
                                    <option value="{{ $form->id }}">{{ $form->name ?? "Form $form->id" }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="user_id">User</label>
                                <select name="user_id" id="user_id" class="form-control">
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Assign</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
