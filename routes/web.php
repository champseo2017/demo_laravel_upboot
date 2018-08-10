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

Route::get('test', 'HomeController@test');
Route::get('/home/gramp/{key_id}', 'HomeController@grap')->name('gramp');
Route::get('/home/monitor/{key_id}', 'HomeController@index');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home/statuspage/Ajax.php', function () {

});


Route::get('/home/statuspage/Logs','LogviewController@ajax');


Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/admin', 'AdminController@index');

Route::prefix('admin')->group(function() {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
  });


  //admin route 
Route::group(['namespace'=>'Admin'],function(){
   
    // Adduser Routes
     Route::resource('admin/adduser','AdduserController');

     // Adduser domain
     Route::resource('admin/domain','DomainController');
     Route::get('/home/statuspage','LogsController@index')->name('statuspage');

 
});

Route::get('/home/modul/Logs','ModulController@index')->name('modul');


//   //route data 
//   Route::group(['namespace'=>'Admin','as'=>'processingchart'],function(){
   
//      Route::get('data/chart','DatachartController@index')->name('datafeed');

// });
