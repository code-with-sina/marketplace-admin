<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthorityController;
use App\Http\Controllers\LoginController;

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


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/get-users', [AdminController::class, 'fetchUsers']);
    Route::get('/get-type', [AdminController::class, 'fetchType']);
    Route::post('/create-wallet', [AdminController::class, 'createWallet']);
    Route::get('/fetch-wallet', [AdminController::class, 'fetchWallet']);
    Route::post('/create-wallet-option', [AdminController::class, 'createWalletOption']);
    Route::post('/create-wallet-option-requirement', [AdminController::class, 'createWalletOptionRequirement']);
    Route::get('/fetch-admin', [AdminController::class, 'fetchStaff']);

    Route::get('/get-p2p-orders', [AdminController::class, 'getP2POrders']);

    Route::post('activate-wallet',     [AdminController::class, 'activateWallet']);
    Route::post('pause-wallet',     [AdminController::class, 'pauseWallet']);
    Route::post('create-ewallet', [AdminController::class, 'createWallet']);

    Route::post('/fetch-wallet-option', [AdminController::class, 'fetchWalletOption']);

    Route::post('create-admin',                 [AdminAuthorityController::class, 'createAdmin']);
    Route::post('revoke-admin',                 [AdminAuthorityController::class, 'revokeAdmin']);
    Route::post('sack-admin',                   [AdminAuthorityController::class, 'sackAdmin']);
    Route::post('promote-admin',                [AdminAuthorityController::class, 'promoteAdmin']);
    Route::post('query-admin',                  [AdminAuthorityController::class, 'queryAdmin']);
    Route::post('change-admin-status',          [AdminAuthorityController::class, 'changeAdminStatus']);
    Route::post('logout',                       [AuthController::class, 'logout']);
    Route::post('fetch-single-user',            [AdminController::class, 'fetchSingleUser']);


    Route::get('get-p2p-by-latest-5',           [AdminController::class, 'getOngoingTransaction']);
    Route::get('get-tickets-by-latest-5',       [AdminController::class, 'getCurrentTickets']);
    Route::post('cancel-transaction',           [AdminController::class, 'cancelSession']);
    Route::post('complete-transaction',         [AdminController::class, 'completeTransaction']);
    Route::post('reinburse-seller',             [AdminController::class, 'reinburseSeller']);

    Route::get('auditrail',                     [AdminAuthorityController::class, 'getTrackFromFrontEnd']);
    Route::get('auditrail/{uuid}',              [AdminAuthorityController::class, 'getTrackFromFrontEndForSingleUser']);
    Route::get('logtrail',                      [AdminAuthorityController::class, 'getErrorLogFromFrontEnd']);
    Route::get('logtrail/{uuid}',               [AdminAuthorityController::class, 'getErrorLogFromFrontEndForSingleUser']);
    Route::post('user-trail',                   [AdminAuthorityController::class, 'getUserTrail']);
    Route::post('user-trail-by-date',           [AdminAuthorityController::class, 'getUserTrailByDate']);
});

Route::post('get-full-order-details', [AdminController::class, 'getFullOrderDetails']);

Route::get('/generate-token', [AdminAuthorityController::class, 'generateToken']);
Route::post('login', [AuthController::class, 'authenticate']);
Route::post('register', [AuthController::class, 'register']);

Route::get('admin-staff', [AuthController::class, 'getListOfAdminStaff']);
