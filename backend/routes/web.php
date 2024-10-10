<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/client', function () {
    return view('client.home');
});

Route::prefix('users')->group( function () {
    Route::get('/',                              [UserController::class, 'index'])->name('users.index');

    Route::get('/add',                         [UserController::class, 'add'])->name('users.add');
    Route::post('/store',                        [UserController::class, 'store'])->name('users.store');

    Route::get('show/{id}',                          [UserController::class, 'show'])->name('users.show');

    Route::get('/edit/{id}',                         [UserController::class, 'edit'])->name('users.edit');
    Route::put('update/{id}',                          [UserController::class, 'update'])->name('users.update');

    Route::delete('/users/{id}/delete',             [UserController::class, 'destroy'])->name('users.delete');
    // web.php
    Route::post('/users/deleteMultiple', [UserController::class, 'deleteMultiple'])->name('users.deleteMultiple');


});
