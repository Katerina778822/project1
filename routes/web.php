<?php

use App\Http\Controllers\B24UserController;
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

Route::get('/home', function () {
    return view('home');
});




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

Route::resource('event','App\Http\Controllers\EventController')->middleware(['auth']);
Route::get('event/create', 'App\Http\Controllers\EventController@create')->middleware('can:event.add')->name('event.create');
Route::get('event/{event}/edit', [EventController::class, 'edit'])->middleware(['can:event.edit'])->name('event.edit');
Route::delete('event/{event}',[EventController::class, 'destroy'])->middleware(['can:event.delete'])->name('event.destroy');
Route::get('event', [EventController::class, 'index'])->middleware(['can:event.read.list'])->name('event.index');

Route::resource('B24User','App\Http\Controllers\B24UserController')->middleware(['auth']);
Route::get('B24User/create', 'App\Http\Controllers\B24UserController@create')->middleware('can:B24User.add')->name('B24User.create');
Route::get('B24User/{B24User}/edit', [B24UserController::class, 'edit'])->middleware(['can:B24User.edit'])->name('B24User.edit');
Route::delete('B24User/{B24User}',[B24UserController::class, 'destroy'])->middleware(['can:B24User.delete'])->name('B24User.destroy');
Route::get('B24User', [B24UserController::class, 'index'])->middleware(['can:B24User.read.list'])->name('B24User.index');

Route::resource('business','App\Http\Controllers\BusinessController')->middleware(['auth']);
Route::get('business/create', 'App\Http\Controllers\BusinessController@create')->middleware('can:business.add')->name('business.create');
Route::get('business/{business}/edit', [App\Http\Controllers\BusinessController::class, 'edit'])->middleware(['can:business.edit'])->name('business.edit');
Route::delete('business/{business}',[App\Http\Controllers\BusinessController::class, 'destroy'])->middleware(['can:business.delete'])->name('business.destroy');
Route::get('business', [App\Http\Controllers\BusinessController::class, 'index'])->middleware(['can:business.read.list'])->name('business.index');

Route::resource('branch','App\Http\Controllers\BranchController')->middleware(['auth']);
Route::get('branch/create', 'App\Http\Controllers\BranchController@create')->middleware('can:branch.add')->name('branch.create');
Route::get('branch/{branch}/edit', 'App\Http\Controllers\BranchController@edit')->middleware(['can:branch.edit'])->name('branch.edit');
Route::delete('branch/{branch}','App\Http\Controllers\BranchController@destroy')->middleware(['can:branch.delete'])->name('branch.destroy');
Route::get('branch', 'App\Http\Controllers\BranchController@index')->middleware(['can:branch.read.list'])->name('branch.index');

Route::resource('role','App\Http\Controllers\RoleController')->middleware(['role:super-user|admin|director']);
Route::get('role/create', 'App\Http\Controllers\RoleController@create')->middleware('can:role.add')->name('role.create');
Route::get('role/{role}/edit', [App\Http\Controllers\RoleController::class, 'edit'])->middleware(['can:role.edit'])->name('role.edit');
Route::delete('role/{role}',[App\Http\Controllers\RoleController::class, 'destroy'])->middleware(['can:B24User.delete'])->name('role.destroy');
Route::get('role', [App\Http\Controllers\RoleController::class, 'index'])->middleware(['can:role.read.list'])->name('role.index');

Route::resource('user','App\Http\Controllers\UserController')->middleware(['auth']);
Route::get('user/create', 'App\Http\Controllers\UserController@create')->middleware('can:user.add')->name('user.create');
Route::get('user/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->middleware(['can:user.edit'])->name('user.edit');
Route::delete('user/{user}',[App\Http\Controllers\UserController::class, 'destroy'])->middleware(['can:B24User.delete'])->name('user.destroy');
Route::get('user', [App\Http\Controllers\UserController::class, 'index'])->middleware(['can:user.read.list'])->name('user.index');


Route::resource('raport','App\Http\Controllers\B24RaportController')->middleware(['auth']);
Route::resource('agenda','App\Http\Controllers\B24AgendaController')->middleware(['auth']);
Route::resource('company','App\Http\Controllers\CompanyController')->middleware(['auth']);
Route::resource('node','App\Http\Controllers\NodeController')->middleware(['auth']);
Route::resource('catalog','App\Http\Controllers\CatalogController')->middleware(['auth']);
Route::resource('goods','App\Http\Controllers\GoodsController')->middleware(['auth']);
Route::resource('selector','App\Http\Controllers\SelectorController')->middleware(['auth']);
Route::resource('b24analitics_companies_date', 'App\Http\Controllers\B24AnaliticsCompanyColdController')->middleware(['auth']);


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
Route::get('/Bitrix24/UpdatecompanySTATUS', [App\Http\Controllers\CompanyController::class, 'UpdateStatusCompaniesJob'])->middleware(['auth'])
->name('UpdatecompanySTATUS');


Route::post('/Bitrix24/field', [App\Http\Controllers\B24FieldController::class, 'fetchAll'])->middleware(['auth'])
->name('b24field.fetchAll');
Route::post('/Bitrix24/b24user', [App\Http\Controllers\B24UserController::class, 'fetchAll'])->middleware(['auth'])
->name('b24user.fetchAll');
Route::post('/Bitrix24/b24ring', [App\Http\Controllers\B24RingController::class, 'fetchAll'])->middleware(['auth'])
->name('b24ring.fetchAll');
Route::post('/Bitrix24/b24task', [App\Http\Controllers\B24TaskController::class, 'fetchAll'])->middleware(['auth'])
->name('b24task.fetchAll');
Route::post('/bitrix24/b24activity', [App\Http\Controllers\B24ActivityController::class, 'index'])->middleware(['auth'])
->name('b24activity.fetchAll');
Route::post('/Bitrix24/b24deal', [App\Http\Controllers\B24DealController::class, 'fetchAll'])->middleware(['auth'])
->name('b24deal.fetchAll');
Route::post('/Bitrix24/b24lead', [App\Http\Controllers\B24LeadController::class, 'fetchAll'])->middleware(['auth'])
->name('b24lead.fetchAll');
Route::post('/Bitrix24/b24contacts', [App\Http\Controllers\B24ContactController::class, 'fetchAll'])->middleware(['auth'])
->name('b24contact.fetchAll');

Route::get('/bitrix24/first', function () {
    return view('bitrix24.b24dashboardFirst');
})->middleware(['auth'])->name('/bitrix24/first');

Route::get('/bitrix24/new', function () {
    return view('bitrix24.b24dashboard');
})->middleware(['auth'])->name('/bitrix24/new');

Route::get('/bitrix24/analitics', function () {
    return view('bitrix24.b24dashboardAnalitics ');
})->middleware(['auth'])->name('/bitrix24/analitics');


Route::get('/Bitrix24/newLeadAnalise', [App\Http\Controllers\B24LeadController::class, 'newLeadAnalise'])->middleware(['auth'])
->name('newLeadAnalise');
Route::get('/Bitrix24/analitics/companies_date', [App\Http\Controllers\B24AnaliticsController::class, 'companiesDate'])->middleware(['auth'])
->name('b24contact.analitics.companies_date');
Route::get('/Bitrix24/analitics/b24contact.analitics.companies_date_index', [App\Http\Controllers\B24AnaliticsController::class, 'companiesDateShow'])->middleware(['auth'])
->name('b24contact.analitics.companies_date_show');

Route::get('/Bitrix24/analitics/company_cold_show_raport/{date}', [App\Http\Controllers\B24AnaliticsCompanyColdController::class, 'showColdCompanies'])->middleware(['auth'])
->name('company_cold_show_raport');
Route::get('/Bitrix24/analitics/company_cold_show_calculate/{date}', [App\Http\Controllers\B24AnaliticsCompanyColdController::class, 'CalcRaport'])->middleware(['auth'])
->name('company_cold_show_calculate');
Route::get('/Bitrix24/analitics/companies_cold_date', [App\Http\Controllers\B24AnaliticsCompanyColdController::class, 'companiesDate'])->middleware(['auth'])
->name('b24contact.analitics.companies_cold_date');
Route::get('/Bitrix24/analitics/companies_cold_date/details/{item}', [App\Http\Controllers\B24AnaliticsCompanyColdController::class, 'showColdCompaniesInfo'])->middleware(['auth'])
->name('b24analitics_companies_date.showColdCompaniesInfo');
//Route::get('/Bitrix24/analitics/b24contact.analitics.companies_cold_date_index', [App\Http\Controllers\B24AnaliticsCompanyColdController::class, 'index'])->middleware(['auth'])
//->name('b24contact.analitics.companies_cold_date_index');


Route::post('/bitrix24/fetchstate', [App\Http\Controllers\B24FetchController::class, 'fetchState'])->middleware(['auth'])
->name('b24fetch.state');

Route::post('/bitrix24/updateData', [App\Http\Controllers\B24FetchController::class, 'fetchAll'])->middleware(['auth'])
->name('b24fetch.updateData');

Route::post('/bitrix24/updateDataRing', [App\Http\Controllers\B24FetchController::class, 'updateDataRing'])->middleware(['auth'])
->name('b24fetch.updateDataRing');
Route::post('/bitrix24/updateDataTask', [App\Http\Controllers\B24FetchController::class, 'updateDataTask'])->middleware(['auth'])
->name('b24fetch.updateDataTask');
Route::post('/bitrix24/updateDataActivity', [App\Http\Controllers\B24FetchController::class, 'updateDataActivity'])->middleware(['auth'])
->name('b24fetch.updateDataActivity');
Route::post('/bitrix24/updateDataCompany', [App\Http\Controllers\B24FetchController::class, 'updateDataCompany'])->middleware(['auth'])
->name('b24fetch.updateDataCompany');
Route::post('/bitrix24/updateDataDeal', [App\Http\Controllers\B24FetchController::class, 'updateDataDeal'])->middleware(['auth'])
->name('b24fetch.updateDataDeal');
Route::post('/bitrix24/updateDataLead', [App\Http\Controllers\B24FetchController::class, 'updateDataLead'])->middleware(['auth'])
->name('b24fetch.updateDataLead');
