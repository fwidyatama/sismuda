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
Route::group(['middleware'=>'auth'],function(){
    Route::group(['middleware'=>'coordinator','prefix' => 'officer'], function () {
        Route::get('/showofficer','UserController@showofficerlist')->name('user.showofficerlist');
        Route::get('/addofficer','UserController@showOfficerForm')->name('user.addofficer');
        Route::post('/storeofficer','UserController@storeOfficer')->name('user.storeofficer');
        Route::get('/deleteofficer/{id}','UserController@destroyOfficer')->name('user.destroyofficer');
        Route::get('/editofficer/{id}','UserController@editOfficer')->name('user.editofficer');
        Route::post('/updatedofficer/{id}','UserController@updateOfficer')->name('user.updateofficer');
        Route::get('/detailofficer/{id}','UserController@showProfile')->name('user.detailofficer');    
    });

    Route::group(['middleware'=>'coordinator','prefix' => 'bus'], function () {
        Route::get('/showbus','BusController@showBusList')->name('bus.showbuslist');
        Route::get('/addbus','BusController@showBusForm')->name('bus.addbus');
        Route::post('/storebus','BusController@storeBus')->name('bus.storebus');
        Route::get('/deletebus/{hullcode}','BusController@deleteBus')->name('bus.destroybus');
        Route::post('/updatebus/{hullcode}','BusController@updatebus')->name('bus.updatebus');
        Route::get('/editbus/{hullcode}','BusController@editbus')->name('bus.editbus');
    });
    
    Route::group(['middleware'=>'logistic','prefix' => 'sparepart'], function () {
        Route::get('/showsparepart','SparepartController@showSparepartList')->name('sparepart.showsparepartlist');
        Route::get('/addsparepart','SparepartController@showSparepartForm')->name('sparepart.addsparepart');
        Route::post('/storesparepart','SparepartController@storeSparepart')->name('sparepart.storesparepart');
        Route::get('/editsparepart/{id}','SparepartController@editSparepart')->name('sparepart.editsparepart');
        Route::post('/updatesparepart/{id}','SparepartController@updateSparepart')->name('sparepart.updatesparepart');
        Route::get('/deletesparepart/{id}','SparepartController@deleteSparepart')->name('sparepart.deletesparepart');
        Route::get('/download/sparepartreport','SparepartController@downloadSparepartReport')->name('sparepart.downloadreport');
        
    });

    Route::group(['middleware'=>'coordinator','prefix' => 'workshop'], function () {
        Route::get('/showworkshop','WorkshopController@showWorkshopList')->name('workshop.showworkshop');
        Route::get('/addworkshop','WorkshopController@showWorkShopForm')->name('workshop.addworkshop');
        Route::post('/storeworkshop','WorkshopController@storeWorkshops')->name('workshop.storeworkshop');
        Route::get('/editworkshop/{workshopnumber}','WorkshopController@editWorkshop')->name('workshop.editworkshop');
        Route::post('/updateworkshop/{workshopnumber}','WorkshopController@updateWorkshop')->name('workshop.updateworkshop');
        Route::get('/deleteworkshop/{workshopnumber}','WorkshopController@deleteWorkshop')->name('workshop.destroyworkshop');
        
    });

    Route::group(['middleware'=>'coordinator','prefix' => 'sparepartorder'], function () {
        Route::get('/showorder','SparepartOrderController@showOrderList')->name('order.showlist');
        Route::get('/detailorder/{id}','SparepartOrderController@detailOrder')->name('order.detailorder');
        Route::post('/verifyorder/{id}','SparepartOrderController@verifyOrder')->name('order.verifyorder');
        Route::get('/download/order','SparepartOrderController@downloadList')->name('order.download');
    });


    Route::group(['middleware'=>'mechanic','prefix' => 'order'], function () {
        Route::get('/ordersparepart','SparepartOrderController@showOrderForm')->name('order.addorder');
        Route::post('/storeorder','SparepartOrderController@storeOrder')->name('order.storeorder');
      
       
    });
    
    //belum ada middleware
    Route::group(['middleware'=>'crew','prefix' => 'buscheck'], function () {
        Route::get('/requestcheck','BusCheckingController@showCheckingForm')->name('buscheck.requestcheck');
        Route::post('/storecheck','BusCheckingController@storeBusChecking')->name('buscheck.storecheck');
    });

    Route::group(['middleware'=>'coordinator','prefix' => 'permits'], function () {
        Route::get('/showlist','BusPermitController@showList')->name('permits.showlist');
        Route::get('/deletelist/{id}','BusPermitController@deleteList')->name('permits.deletelist');
    });

    Route::group(['middleware'=>'coordinator','prefix' => 'buscheck'], function () {
        Route::get('/showorder','BusCheckingController@showBusCheck')->name('buscheck.show');
        Route::get('/deleteorder/{id}','BusCheckingController@deleteOrder')->name('buscheck.delete');
        Route::get('/detailorder/{id}','BusCheckingController@detailOrder')->name('buscheck.detailorder');
        Route::post('/verifyorder/{id}','BusCheckingController@verifyOrder')->name('buscheck.verifyorder');

    });
    
    Route::group(['middleware'=>'mechanic','prefix' => 'permits'], function () {
        Route::get('/showform','BusPermitController@showPermitForm')->name('permits.request');
        Route::post('/storeform','BusPermitController@storePermit')->name('permits.store');
    });

    Route::group(['middleware'=>'logistic','prefix' => 'mutation'], function () {
        Route::get('/addmutation','MutationController@addMutation')->name('mutation.add');
        Route::post('/storemutation','MutationController@storeMutations')->name('mutation.store');
        Route::get('/showall','MutationController@showMutation')->name('mutation.show');
        Route::get('/downloadreport','MutationController@downloadReport')->name('mutation.download');
    });

    Route::get('/workshop/history','WorkshopController@showHistory')->name('workshop.historyworkshop')->middleware('mechanic');
    Route::get('/sparepart','SparepartOrderController@acceptedOrder')->name('sparepart.accepted')->middleware('logistic');
    Route::get('/profil/{id}','UserController@showProfile')->name('profile');
    Route::get('/editprofile/{id}','UserController@editProfile')->name('editprofile');
    Route::post('/updateprofile/{id}','UserController@updateProfile')->name('updateprofile');
   
    // Route::get('/getofficerlist','UserController@officerList')->name('user.getofficerlist');
});
Route::get('/user','WorkshopController@getUserAjax')->name('workshop.getuser');
Route::get('/bus','WorkshopController@getBusAjax')->name('workshop.getbus');
Route::get('/getsparepart','SparepartOrderController@getSparepart');

Route::post('/storespareparttest','SparepartOrderController@order')->name('sparepart.post');
Route::post('/storeworkshoptest','WorkshopController@storeWorkshop')->name('workshop.post');
Route::post('/storebuscheck','BusCheckingController@storeOrder')->name('buscheck.post');
Route::post('/storepermit','BusPermitController@storePermit')->name('buscheck.verify');