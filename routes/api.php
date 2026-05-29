<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Api\QuickActionApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/create-account', [ApiAuthController::class, 'register']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->prefix('quick-actions')->group(function () {
    Route::get('services', [QuickActionApiController::class, 'services']);
    Route::post('services/{service}/pay', [QuickActionApiController::class, 'pay']);
    Route::get('beneficiaries', [QuickActionApiController::class, 'beneficiaries']);
    Route::post('beneficiaries', [QuickActionApiController::class, 'storeBeneficiary']);
    Route::delete('beneficiaries/{beneficiary}', [QuickActionApiController::class, 'destroyBeneficiary']);
});
