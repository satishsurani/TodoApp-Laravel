<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::get("/", [TodoController::class, "index"])->name("index");
Route::post("insert", [TodoController::class, "store"])->name('insert');
Route::post("update/{id}", [TodoController::class, "update"])->name('update');
Route::delete("delete/{id}", [TodoController::class, "destroy"])->name('delete');
Route::get('/search', [TodoController::class, 'search'])->name('search');
Route::delete("deleteMultiple", [TodoController::class, "destroyMultiple"])->name('deleteMultiple');
