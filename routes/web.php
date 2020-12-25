<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('queues');
})->name('home');

Route::Post('direct','Controller@direct')->name('direct');
Route::Post('directRandom','Controller@directRandom')->name('directRandom');

Route::prefix('systemOne')->group(function(){
    Route::post('store','firstSystemController@store')->name('store');
    Route::prefix('caseOne')->group(function(){
        Route::get('tiCaseOne','firstSystemController@tiCaseOne')->name('tiCaseOne');
        Route::get('collectn','firstSystemController@collectnGenerallyCaseOne')->name('collectnGenerallyCaseOne');
        Route::get('collectWq','firstSystemController@collectWqGenerallyCaseOne')->name('collectWqGenerallyCaseOne');
        Route::post('storeM','firstSystemController@storeM')->name('storeM');
    });
    Route::prefix('caseTwo')->group(function(){
        Route::get('tiCaseTwo','firstSystemController@tiCaseTwo')->name('tiCaseTwo');
        Route::get('collectn2','firstSystemController@collectnGenarallyCaseTwo')->name('collectnGenarallyCaseTwo');
        Route::get('collectWq2','firstSystemController@collectWqGenerallyCaseTwo')->name('collectWqGenerallyCaseTwo');

    });
    Route::get('results/{case}','firstSystemController@show')->name('show');
    Route::post('calculateNt','firstSystemController@calculateNt')->name('calculateNt');
    Route::post('calculateWqn','firstSystemController@calculateWqn')->name('calculateWqn');
    Route::post('calculateNtCaseTwo','firstSystemController@calculateNtCaseTwo')->name('calculateNtCaseTwo');
    Route::post('calculateWqnCaseTwo','firstSystemController@calculateWqnCaseTwo')->name('calculateWqnCaseTwo');

});


Route::prefix('systemTwo')->group(function(){
    Route::post('store','SecondSystemController@store')->name('store');
    Route::get('calculateLST','SecondSystemController@calculateLST')->name('calculateLST');
    Route::post('calculatePn','SecondSystemController@calculatePn')->name('calculatePnST');
});


Route::prefix('systemThree')->group(function(){
    Route::post('store','SystemThreeController@store')->name('store');

    Route::get('calculatep','SystemThreeController@calculatep')->name('calculatep');
    Route::get('calculatePo','SystemThreeController@calculatePo')->name('calculatePo');
    Route::get('calculateLSTh','SystemThreeController@calculateLSTh')->name('calculateLSTh');
    Route::get('calculateWqSTh','SystemThreeController@calculateWqSTh')->name('calculateWqSTh');

    Route::post('calculatePnSThree','SystemThreeController@calculatePnSThree')->name('calculatePnSThree');

});


Route::prefix('systemFour')->group(function(){
    Route::post('store','SystemFourController@store')->name('store');
    Route::get('PoSystemFour','SystemFourController@PoSystemFour')->name('PoSystemFour');
    Route::get('calculateLqSFour','SystemFourController@calculateLqSFour')->name('calculateLqSFour');

    Route::post('calculatePnSFour','SystemFourController@calculatePnSFour')->name('calculatePnSFour');

});

Route::prefix('systemFive')->group(function(){
    Route::post('store','SystemFiveController@store')->name('store');
    Route::get('PoSystemFive','SystemFiveController@PoSystemFive')->name('PoSystemFive');
    Route::get('calculateLqSFive','SystemFiveController@calculateLqSFive')->name('calculateLqSFive');

    Route::post('calculatePnSFive','SystemFiveController@calculatePnSFive')->name('calculatePnSFive');

});

Route::get('A7A',function(){
    return  'Current PHP version: ' . phpversion();
});






