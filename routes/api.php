<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UtilController;
use App\Http\Controllers\API\PersonController;
use App\Http\Controllers\API\ResidentialController;
use App\Http\Controllers\API\TowerController;
use App\Http\Controllers\API\ApartmentController;
use App\Http\Controllers\API\BankController;
use App\Http\Controllers\API\ConfigPayController;
use App\Http\Controllers\API\ReceiptController;

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

Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);
Route::post('registerUserTower', [AuthController::class, 'registerUserTower']);
Route::post('generateAuth', [UtilController::class, 'generateAuth']);
Route::post('forgotPassword', [UtilController::class, 'forgotPassword']);
Route::post('person', [PersonController::class, 'index']);
Route::post('residentials', [ResidentialController::class, 'index']);
Route::post('tower', [TowerController::class, 'store']);
Route::post('apartment', [ApartmentController::class, 'store']);
Route::post('configPay', [ConfigPayController::class, 'store']);
Route::post('savePerfil', [PersonController::class, 'savePerfil']);
Route::post('saveBank', [BankController::class, 'saveBank']);
Route::post('saveBankResidential', [BankController::class, 'saveBankResidential']);
Route::post('saveVoucher', [ReceiptController::class, 'saveVoucher']);
Route::post('saveReceipt', [ReceiptController::class, 'saveReceipt']);
Route::post('savePayment', [ReceiptController::class, 'savePayment']);
Route::post('saveImageVoucher', [ReceiptController::class, 'saveImageVoucher']);


Route::get('getTypeDocument', [UtilController::class, 'getTypeDocument']);
Route::get('getBanks', [UtilController::class, 'getBanks']);
Route::get('getPlans', [UtilController::class, 'getPlans']);
Route::get('getTimePlan', [UtilController::class, 'getTimePlan']);
Route::get('getCityByIdState/{idState}', [UtilController::class, 'getCityByIdState']);
Route::get('getOwnerDocument/{user}', [ApartmentController::class, 'getOwnerDocument']);
Route::get('getCountry', [UtilController::class, 'getCountry']);
Route::get('getCountryById/{country}', [UtilController::class, 'getCountryById']);
Route::get('getStateById/{idCountry}', [UtilController::class, 'getStateById']);
Route::get('getCityByIdCountry/{idCountry}', [UtilController::class, 'getCityByIdCountry']);
Route::get('getParishByIdCity/{idCity}', [UtilController::class, 'getParishByIdCity']);
Route::get('getPhoneAreaCodeByIdCity/{idCity}', [UtilController::class, 'getPhoneAreaCodeByIdCity']);
Route::get('getPhoneAreaCod', [UtilController::class, 'getPhoneAreaCod']);
Route::get('getBankTypeAccount', [UtilController::class, 'getBankTypeAccount']);
Route::get('getCIType', [UtilController::class, 'getCIType']);
Route::get('getRifType', [UtilController::class, 'getRifType']);
Route::get('getValueUSD', [UtilController::class, 'getValueUSD']);
Route::get('getChargesMethods', [UtilController::class, 'getChargesMethods']);
Route::get('getPaymentMethods', [UtilController::class, 'getPaymentMethods']);
Route::get('getPerfilData/{idUser}', [UtilController::class, 'getPerfilData']);
Route::get('getNumberTower/{idUser}', [ResidentialController::class, 'getNumberTower']);
Route::get('getTowerCredential/{idUser}', [ResidentialController::class, 'getTowerCredential']);
Route::get('getIdResidential/{idUser}', [ResidentialController::class, 'getIdResidential']);
Route::get('getConfigPay/{idUser}', [ResidentialController::class, 'getConfigPay']);
Route::get('getAliquotDifferent/{idResidential}', [ResidentialController::class, 'getAliquotDifferent']);
Route::get('getApartmentAliquot/{idResidential}', [ResidentialController::class, 'getApartmentAliquot']);
Route::get('getBanksDataResidence/{idResidential}', [ResidentialController::class, 'getBanksDataResidence']);
Route::get('getBanksData/{idResidential}', [ResidentialController::class, 'getBanksData']);
Route::get('getResidentialById/{idResidential}', [ResidentialController::class, 'getResidentialById']);
Route::get('getTowerApartmentByIdResdential/{idResidential}', [ResidentialController::class, 'getTowerApartmentByIdResdential']);
Route::get('getUser/{user}', [AuthController::class, 'getUser']);
Route::get('getBankByUser/{idUser}', [BankController::class, 'getBankByUser']);
Route::get('getBankByResidential/{idResidential}', [BankController::class, 'getBankByResidential']);
Route::get('getNumberReceipt', [ReceiptController::class, 'getNumberReceipt']);
Route::get('getReceiptByIdResidential/{idResidential}', [ReceiptController::class, 'getReceiptByIdResidential']);
Route::get('getReceiptByIdUser/{idUser}', [ReceiptController::class, 'getReceiptByIdUser']);
Route::get('getDefaultersByIdResidential/{idResidential}', [ReceiptController::class, 'getDefaultersByIdResidential']);
Route::get('getPaymentByIdApartment/{idApartment}', [ReceiptController::class, 'getPaymentByIdApartment']);


Route::put('upTower', [TowerController::class, 'update']);
Route::put('upApartment', [ApartmentController::class, 'update']);
Route::put('changePassword', [AuthController::class, 'changePassword']);
Route::put('updateBank', [BankController::class, 'updateBank']);
Route::put('updateBankResidential', [BankController::class, 'updateBankResidential']);


Route::post('deleteUser', [AuthController::class, 'deleteUser']); //usa