<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PermissionController;

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
Route::prefix('permissions')->group(function () {
    Route::get('/', [PermissionController::class, 'index']);
    Route::get('/{id}', [PermissionController::class, 'show']);
    Route::post('/', [PermissionController::class, 'storeOrUpdate']);
    Route::put('/{id}', [PermissionController::class, 'storeOrUpdate']);
    Route::delete('/{id}', [PermissionController::class, 'destroy']); // xóa mềm perrmission
    Route::post('/deleteMutipath',[PermissionController::class,'detroyPermissionValue']); // xóa mềm permission value
    Route::post('/deletePermission/{id}',[PermissionController::class,'deletePermission']); //xóa cứng permission
    Route::post('/deletePervalue',[PermissionController::class,'detroyValuePermission']); // xóa cứng permission value
});

