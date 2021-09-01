<?php

use App\Http\Controllers\UserController;
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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['checkIsAdmin'])->group(function () {
    Route::get('/setting', [App\Http\Controllers\HomeController::class, 'setting'])->name('setting');
    Route::post('can-order', [App\Http\Controllers\HomeController::class, 'canOrder'])->name('canOrder');

    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::get('list', [App\Http\Controllers\UserController::class, 'list'])->name('list');

    Route::resource('menu', App\Http\Controllers\MenuController::class);
    Route::get('chooseDateRange', [App\Http\Controllers\MenuController::class, 'chooseDateRange'])->name('chooseDateRange');
    Route::get('chooseDateRangeList', [App\Http\Controllers\MenuController::class, 'chooseDateRangeList'])->name('chooseDateRange.list');
    Route::get('menu-index/{id}', [App\Http\Controllers\MenuController::class, 'menusIndex'])->name('menus_index');
    Route::get('sessionOneList/{days}/{date_range}', [App\Http\Controllers\MenuController::class, 'sessionOneList'])->name('sessionOneList');
    Route::get('sessionTwoList/{days}/{date_range}', [App\Http\Controllers\MenuController::class, 'sessionTwoList'])->name('sessionTwoList');
    Route::post('import/menu', [App\Http\Controllers\MenuController::class, 'foodImport'])->name('import-food');

    Route::resource('classes', App\Http\Controllers\StudentClassController::class);
    Route::get('class/list', [App\Http\Controllers\StudentClassController::class, 'list'])->name('class.list');
    Route::get('class/{id}', [App\Http\Controllers\StudentClassController::class, 'class'])->name('class.name-list');
    Route::get('class/{id}/list', [App\Http\Controllers\StudentClassController::class, 'nameList'])->name("class.name-list-list");
    Route::get('class-orderDateRange/{id}', [App\Http\Controllers\StudentClassController::class, 'orderDateRange'])->name('orderDateRange');
    Route::get('class/{id}/order', [App\Http\Controllers\StudentClassController::class, 'order'])->name('class.order');
    Route::get('class/{id}/orderDetails', [App\Http\Controllers\StudentClassController::class, 'orderDetails'])->name('class.orderDetails');

    Route::get('/date-range', [App\Http\Controllers\DateRangeController::class, 'date_range'])->name('date_range');
    Route::get('/date-range-list', [App\Http\Controllers\DateRangeController::class, 'date_range_list']);
    Route::get('/date-range-create', [App\Http\Controllers\DateRangeController::class, 'date_range_create'])->name('date_range.create');
    Route::post('/date-range-store', [App\Http\Controllers\DateRangeController::class, 'date_range_store'])->name('date_range.store');
    Route::get('/date-range-edit/{id}', [App\Http\Controllers\DateRangeController::class, 'date_range_edit'])->name('date_range.edit');
    Route::put('/date-range-update/{id}', [App\Http\Controllers\DateRangeController::class, 'date_range_update'])->name('date_range.update');
    Route::delete('/date-range-delete/{id}', [App\Http\Controllers\DateRangeController::class, 'date_range_delete'])->name('date_range.delete');


    // Route::resource('stalls', App\Http\Controllers\StallController::class);
    // Route::get('stalls-list', [App\Http\Controllers\StallController::class, 'list'])->name('stall-list');
});
Route::middleware(['checkIsKitchenandAdmin'])->group(function () {
    Route::get('/report', [App\Http\Controllers\ReportController::class, 'index'])->name('report.index');
    Route::get('/report/show', [App\Http\Controllers\ReportController::class, 'show'])->name('report.show');
    Route::get('/report/{stall_id}', [App\Http\Controllers\ReportController::class, 'hawkerReportIndex'])->name('report.hawker.index');
    Route::get('/report/{stall_id}/show', [App\Http\Controllers\ReportController::class, 'hawkerReport'])->name('report.hawker');
    Route::post('orders/check-amount', [App\Http\Controllers\OrderController::class, 'checkAmount'])->name('check-amount');
});
Route::get('profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
Route::get('/profile/password', [App\Http\Controllers\UserController::class, 'viewchangePwd'])->name('change-pwd-view');
Route::post('/profile/password/change', [App\Http\Controllers\UserController::class, 'changePassword'])->name('change-pwd');

Route::middleware(['checkUserCanOrder'])->group(function () {
    Route::resource('order', App\Http\Controllers\OrderController::class);
    //Route::post('orders/menu', [App\Http\Controllers\OrderController::class, 'chooseMenu'])->name('chooseMenu')->middleware('checkUserCanOrder');
    Route::post('orders/checkout', [App\Http\Controllers\OrderController::class, 'checkout'])->name('checkout');
});
Route::middleware(['checkUserCanDeleteOrEdit'])->group(function () {
    Route::get('orders/{id}/edit/', [App\Http\Controllers\OrderController::class, 'edits'])->name('editOrder2');
    Route::post('orders/edit', [App\Http\Controllers\OrderController::class, 'editOrder'])->name('editOrder');
    Route::get('orders/delete/{id}', [App\Http\Controllers\OrderController::class, 'deleteOrder'])->name('deleteOrder');
});

Route::get('orders/selectDateRange', [App\Http\Controllers\OrderController::class, 'orderHistorySelectDateRange'])->name('orderHistory.selectDateateRange');
Route::post('orders/history', [App\Http\Controllers\OrderController::class, 'history'])->name('viewOrder');
Route::get('/text-sentiment', [App\Services\TextSentiment::class, 'sentiment'])->name('text-sentiment');
Route::get('KNN/initial', [App\Services\FoodClassificationService\KNN::class, 'initial'])->name('KNN-initial');
Route::post('order/comment', [App\Http\Controllers\TransactionController::class, 'comment'])->name('comment');






//test
Route::get('test/TSP', [App\Services\TestTSP::class, 'test'])->name('test');
Route::get('test/fav', [UserController::class, 'fav_top_5'])->name('test.fav');
Route::get('delivery', [UserController::class, 'dijakstra'])->name('path-to-class');

//good

//Route::post('import/menu', [App\Http\Controllers\MenuController::class, 'foodImport'])->name('import-food');
