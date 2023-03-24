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
    return view('welcome');
});
Route::get('/help', function () {
    return view('help');
})->middleware(['auth'])->name('help');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


/*Route::get('/user/{id}/{username?}', function ($id,$username='Joe') {
    return 'Hello '.$username. 'Your Id is '.$id;
})->name('Achtung!');  
Route::group(['prefix'=>'users'],function(){
    Route::get('{id}/{username?}', function ($id,$username='Joe') {
        return 'Hello '.$username. '! Your Id is '.$id;
    })->name('Achtung!');    
});
Route::get('/tail', function () {
    return view('tailwind'); });
*/



Route::resource('company','App\Http\Controllers\CompanyController');
Route::resource('node','App\Http\Controllers\NodeController');
Route::resource('catalog','App\Http\Controllers\CatalogController');
Route::resource('goods','App\Http\Controllers\GoodsController');
Route::resource('selector','App\Http\Controllers\SelectorController');
Route::get('/export/{node_id}', [App\Http\Controllers\Controller::class, 'exportData'])->name('exp');
Route::get('/node/NodeDownload/{node_id}', [App\Http\Controllers\Controller::class, 'NodeDownload'])
->name('NodeDownload');
Route::get('/fetchToken', [App\Http\Controllers\Controller::class, 'fetchToken'])
->name('fetchToken');
Route::post('/node/exportDataSheet/{node_id}', [App\Http\Controllers\Controller::class, 'exportDataSheet'])
->name('exportDataSheet'); 

Route::get('/selector/createAll/{node_id}', [App\Http\Controllers\SelectorController::class, 'createAll'])
->name('selector.createAll');  
Route::get('/goods/showdetails/{good_id}', [App\Http\Controllers\GoodsController::class, 'showdetails'])
->name('goods.showdetails');  
Route::get('/goods/destroyAllCatalog/{goods}', [App\Http\Controllers\GoodsController::class, 'destroyAllCatalog'])
->name('goods.destroyAllCatalog'); 
Route::get('/catalog/destroyAllNode/{node_id}', [App\Http\Controllers\GoodsController::class, 'destroyAllNode'])
->name('catalog.destroyAllNode');
Route::get('/GoodsPresenter/form', [App\Http\Controllers\GoodsPresenterController::class, 'form'])
->name('GoodsPresenter.form');
Route::post('/GoodsPresenter/PresentGoods', [App\Http\Controllers\GoodsPresenterController::class, 'PresentGoods'])
->name('GoodsPresenter.PresentGoods');
Route::post('/GoodsPresenter/formAdd', [App\Http\Controllers\GoodsPresenterController::class, 'formAdd'])
->name('GoodsPresenter.formAdd');

Route::get('/partial.errorMessage/{error}', function () {
    return view('partial.errorMessage');
})->name('/partial.errorMessag');

Route::post('/Bitrix24/company', [App\Http\Controllers\CompanyController::class, 'fetchAll'])->middleware(['auth'])
->name('company.fetchAll');


Route::post('/Bitrix24/field', [App\Http\Controllers\B24FieldController::class, 'fetchAll'])->middleware(['auth'])
->name('b24field.fetchAll');
Route::post('/Bitrix24/b24user', [App\Http\Controllers\B24UserController::class, 'fetchAll'])->middleware(['auth'])
->name('b24user.fetchAll');
Route::post('/Bitrix24/b24ring', [App\Http\Controllers\B24RingController::class, 'fetchAll'])->middleware(['auth'])
->name('b24ring.fetchAll');
Route::post('/Bitrix24/b24task', [App\Http\Controllers\B24TaskController::class, 'fetchAll'])->middleware(['auth'])
->name('b24task.fetchAll');
Route::post('/Bitrix24/b24deal', [App\Http\Controllers\B24DealController::class, 'fetchAll'])->middleware(['auth'])
->name('b24deal.fetchAll');

Route::get('/bitrix24', function () {
    return view('bitrix24.b24dashboard');
})->middleware(['auth'])->name('/bitrix24');

Route::get('/bitrix24/token', [App\Http\Controllers\bitrix24Controller::class, 'getToken'])
->name('/getToken');
