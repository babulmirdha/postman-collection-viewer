<?php

use App\Http\Controllers\Postman\PostmanCollectionController;
use App\Http\Controllers\Postman\PostmanEnvironmentController;
use App\Http\Controllers\Postman\PostmanTestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


//Postman collection routes

Route::get('/', [PostmanCollectionController::class, 'index'])->name('home');

Route::get('postman', [PostmanCollectionController::class, 'index'])->name('postman.index');

Route::get('/postman/collections/upload', [PostmanCollectionController::class, 'uploadForm'])->name('postman.collections.upload');

Route::post('/postman/collections/upload', [PostmanCollectionController::class, 'storeFile'])->name('postman.collections.upload');

Route::get('postman/collections', [PostmanCollectionController::class, 'index'])->name('postman.collections.index');

Route::get('postman/collections/{id}', [PostmanCollectionController::class, 'show'])->name('postman.collections.show');

Route::get('/postman/collections/{id}', [PostmanCollectionController::class, 'show'])->name('postman.collections.show');
Route::get('/postman/collections/{id}/download', [PostmanCollectionController::class, 'download'])->name('postman.collections.download');
Route::delete('/postman/collections/{id}', [PostmanCollectionController::class, 'destroy'])->name('postman.collections.delete');
// Route::get('/postman/collections/{id}/edit', [PostmanCollectionController::class, 'edit'])->name('postman.collections.edit');
// Route::post('/postman/collections/{id}/update', [PostmanCollectionController::class, 'update'])->name('postman.collections.update');
// Route::get('/postman/collections/{id}/run', [PostmanCollectionController::class, 'run'])->name('postman.collections.run');
// Route::get('/postman/collections/{id}/run/{folder}', [PostmanCollectionController::class, 'runFolder'])->name('postman.collections.run-folder');





Route::post('/postman/test', [PostmanTestController::class, 'run'])->name('postman.test');


//Postman environment routes
Route::get('postman/environments', [PostmanEnvironmentController::class, 'show'])->name('postman.environments.index');

Route::get('/postman/environments/upload', [PostmanEnvironmentController::class, 'uploadForm'])->name('postman.environments.upload');

Route::post('/postman/environments/upload', [PostmanEnvironmentController::class, 'storeFile'])->name('postman.environments.upload');

Route::get('/postman/environments/edit-variables', [PostmanEnvironmentController::class, 'editVariables'])->name('postman.environments.edit-variables');
Route::post('/postman/environments/update-variables', [PostmanEnvironmentController::class, 'updateVariables'])->name('postman.environments.update-variables');
