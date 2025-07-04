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

Route::get('postman/collection', [PostmanCollectionController::class, 'index'])->name('postman.collection.index');

Route::get('/postman/collection/upload', [PostmanCollectionController::class, 'uploadForm'])->name('postman.collection.upload');

Route::post('/postman/collection/upload', [PostmanCollectionController::class, 'storeFile'])->name('postman.collection.upload');

Route::post('/postman/test', [PostmanTestController::class, 'run'])->name('postman.test');


//Postman environment routes
Route::get('postman/environment', [PostmanEnvironmentController::class, 'show'])->name('postman.environment.index');

Route::get('/postman/environment/upload', [PostmanEnvironmentController::class, 'uploadForm'])->name('postman.environment.upload');

Route::post('/postman/environment/upload', [PostmanEnvironmentController::class, 'storeFile'])->name('postman.environment.upload');

Route::get('/postman/environment/edit-variables', [PostmanEnvironmentController::class, 'editVariables'])->name('postman.environment.edit-variables');
Route::post('/postman/environment/update-variables', [PostmanEnvironmentController::class, 'updateVariables'])->name('postman.environment.update-variables');
