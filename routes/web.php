<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('form/{id}/builder', [HomeController::class, 'formBuilder'])->name('form-builder')->middleware('auth');

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

Route::post('save-form', [HomeController::class, 'saveForm'])->name('save-form')->middleware('auth');

Route::post('assign-form', [HomeController::class, 'assignForm'])->name('assign-form')->middleware('auth');


Route::get('form/{id}/fill', [HomeController::class, 'addForm'])->name('fill-form')->middleware('auth');
Route::get('form/{id}/edit', [HomeController::class, 'editForm'])->name('edit-form')->middleware('auth');
Route::get('form/{id}/view', [HomeController::class, 'viewForm'])->name('view-form')->middleware('auth');
Route::post('form/{id}/update', [HomeController::class, 'updateForm'])->name('update-form')->middleware('auth');

Route::get('form/{id}/view', [HomeController::class, 'viewForm'])->name('view-form')->middleware('auth');

Route::get('form/{id}/delete', [HomeController::class, 'deleteForm'])->name('delete-form')->middleware('auth');

Route::get('assign-form/{id}/delete', [HomeController::class, 'deleteAssignForm'])->name('delete-assign-form')->middleware('auth');

