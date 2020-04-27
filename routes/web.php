<?php

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
    return view('auth.login');
});

Auth::routes(['register' => false]);

Route::get('message/send', 'UserController@form')->name('message.form');
Route::post('message/send', 'UserController@send')->name('message.send');




Route::group(['middleware'=>'auth'],function(){
    

    Route::group(['prefix' => 'officer'], function () {
        Route::get('/showofficer','UserController@showofficerlist')->name('user.showofficerlist');
        Route::get('/addofficer','UserController@showOfficerForm')->name('user.addofficer');
        Route::post('/storeofficer','UserController@storeOfficer')->name('user.storeofficer');
        Route::get('/deleteofficer/{id}','UserController@destroyOfficer')->name('user.destroyofficer');
        Route::get('/editofficer/{id}','UserController@editOfficer')->name('user.editofficer');
        Route::post('/updatedofficer/{id}','UserController@updateOfficer')->name('user.updateofficer');    
        Route::get('/detailofficer/{id}','UserController@showProfile')->name('user.detailofficer');    
    });

    Route::group(['prefix' => 'bus'], function () {
        Route::get('/showbus','BusController@showBusList')->name('bus.showbuslist');
        Route::get('/addbus','BusController@showBusForm')->name('bus.addbus');
        Route::post('/storebus','BusController@storeBus')->name('bus.storebus');
        Route::get('/deletebus/{hullcode}','BusController@deleteBus')->name('bus.destroybus');
        Route::post('/updatebus/{hullcode}','BusController@updatebus')->name('bus.updatebus');
        Route::get('/editbus/{hullcode}','BusController@editbus')->name('bus.editbus');
    });
    
    Route::group(['prefix' => 'sparepart'], function () {
        Route::get('/showsparepart','SparepartController@showSparepartList')->name('sparepart.showsparepartlist');
        Route::get('/addsparepart','SparepartController@showSparepartForm')->name('sparepart.addsparepart');
        Route::post('/storesparepart','SparepartController@storeSparepart')->name('sparepart.storesparepart');
        Route::get('/editsparepart/{id}','SparepartController@editSparepart')->name('sparepart.editsparepart');
        Route::post('/updatesparepart/{id}','SparepartController@updateSparepart')->name('sparepart.updatesparepart');
        Route::get('/deletesparepart/{id}','SparepartController@deleteSparepart')->name('sparepart.deletesparepart');
        Route::get('/download/sparepartreport','SparepartController@downloadSparepartReport')->name('sparepart.downloadreport');
        
    });

    Route::group(['prefix' => 'workshop'], function () {
        Route::get('/showworkshop','WorkshopController@showWorkshopList')->name('workshop.showworkshop');
        Route::get('/addworkshop','WorkshopController@showWorkShopForm')->name('workshop.addworkshop');
        Route::post('/storeworkshop','WorkshopController@storeWorkshop')->name('workshop.storeworkshop');
        Route::get('/user','WorkshopController@getUserAjax')->name('workshop.getuser');
        Route::get('/bus','WorkshopController@getBusAjax')->name('workshop.getbus');
        Route::get('/editworkshop/{workshopnumber}','WorkshopController@editWorkshop')->name('workshop.editworkshop');
        Route::post('/updateworkshop/{workshopnumber}','WorkshopController@updateWorkshop')->name('workshop.updateworkshop');
        Route::get('/deleteworkshop/{workshopnumber}','WorkshopController@deleteWorkshop')->name('workshop.destroyworkshop');
    });

    Route::group(['prefix' => 'order'], function () {
        Route::get('/ordersparepart','SparepartOrderController@showOrderForm')->name('order.addorder');
        Route::post('/storeorder','SparepartOrderController@storeOrder')->name('order.storeorder');
        Route::get('/getsparepart','SparepartOrderController@getSparepart');
    });


    Route::group(['prefix' => 'buscheck'], function () {
        Route::get('/requestcheck','BusCheckingController@showCheckingForm')->name('buscheck.requestcheck');
        Route::post('/storecheck','BusCheckingController@storeBusChecking')->name('buscheck.storecheck');
    });
  
    
    
    
    // Route::get('/getofficerlist','UserController@officerList')->name('user.getofficerlist');
});