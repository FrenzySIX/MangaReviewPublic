<?php

use App\Http\Controllers\EditLoginController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', [NoteController::class, 'dashboard'])
    ->middleware(['auth'])->name('dashboard');

Route::post('criar_anotacao', [NoteController::class, 'create'])
    ->middleware(['auth'])->name('create.note');

Route::post('editar_anotacao', [NoteController::class, 'update'])
    ->middleware(['auth'])->name('update.note');

Route::post('excluir_anotacao', [NoteController::class, 'delete'])
    ->middleware(['auth'])->name('delete.note');

Route::post('enviar_arquivo', [NoteController::class, 'uploadFile'])
    ->middleware(['auth'])->name('upload.file');

Route::post('exluir_arquivo', [NoteController::class, 'deleteFile'])
    ->middleware(['auth'])->name('delete.file');

Route::post('baixar_arquivo', [NoteController::class, 'downloadFile'])
    ->middleware(['auth'])->name('download.file');

Route::get('/users/{id}/edit', [EditLoginController::class , 'edit'])
    ->name('users.edit');

Route::put('/users/{id}', [EditLoginController::class , 'updateLogin'])
    ->name('users.update');

require __DIR__.'/auth.php';
