<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register-intern', [UserController::class, 'registerIntern'])->name('create.intern');
Route::get('get-intern', [UserController::class, 'getInterns'])->name('read.intern');
Route::delete('delete-intern/{id}', [UserController::class, 'deleteIntern'])->name('delete.intern');
Route::patch('update-intern/{id}', [UserController::class, 'updateIntern'])->name('update.intern');
