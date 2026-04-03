<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Route::post('/login', [LoginController::class, 'login'])->name('auth.login');
Route::post('/logout', [LoginController::class, 'logout'])->name('auth.logout')->middleware('auth');

Route::middleware('auth')->controller(LoginController::class)->group(function() {
    Route::get('/dashboard', 'index')->name('auth.index');
});

Route::resource('products',ProductsController::class)->middleware(IsAdmin::class); 
Route::middleware(IsAdmin::class)->controller(ProductsController::class)->group(function() {
    Route::post('/{uuid}/active','activeToggle')->name('products.active');
});
Route::resource('categories',CategoriesController::class)->middleware(IsAdmin::class)->except(['show']);

Route::middleware(IsAdmin::class)->controller(SettingsController::class)->group(function() {
    Route::get('/settings','index')->name('settings.index');
    Route::post('/settings/table/create','tableCreate')->name('settings.table.create');
    Route::post('/settings/table/sort','tableSort')->name('settings.table.sort');
    Route::delete('/settings/table/{uuid}/delete','tableDelete')->name('settings.table.delete');
    Route::post('/settings/payment/tax/update','paymentTaxUpdate')->name('settings.payment.tax.update');
    Route::post('/settings/restaurant/update','restaurantUpdate')->name('settings.restaurant.update');
});
Route::middleware('auth')->controller(TransactionsController::class)->group(function(){
    Route::post('/transaction/create','create')->name('transaction.create');
    Route::get('/transaction/{uuid}/show','show')->name('transaction.show');
    Route::delete('/transaction/{uuid}/delete','delete')->name('transaction.delete');
    Route::post('/transaction/{uuid}/update','update')->name('transaction.update');
    Route::post('/transaction/order/{uuid}/create','createOrder')->name('transaction.order.create');
    Route::post('/transaction/order/{uuid}/increment','incrementOrder')->name('transaction.order.increment');
    Route::post('/transaction/order/{uuid}/decrement','decrementOrder')->name('transaction.order.decrement');
    Route::post('/transaction/order/{uuid}/changeQty','changeQtyOrder')->name('transaction.order.changeQty');
    Route::post('/transaction/order/{uuid}/changeTable','changeTableOrder')->name('transaction.order.changeTable');
    Route::post('/transaction/order/{uuid}/changeOrder','changeOrderType')->name('transaction.order.changeOrderType');
    Route::post('/transaction/order/{uuid}/changeName','changeNameOrder')->name('transaction.order.changeName');
    Route::get('/transaction/order/{uuid}/getNote','getNoteOrder')->name('transaction.order.getNote');
    Route::post('/transaction/order/{uuid}/changeNote','changeNoteOrder')->name('transaction.order.changeNote');
    Route::delete('/transaction/order/{uuid}/deleteOrder','deleteOrder')->name('transaction.order.delete');
    Route::post('/transaction/{uuid}/submit','submitTransaction')->name('transaction.submit');
    Route::get('/transaction/{uuid}/payment','paymentTransaction')->name('transaction.payment');
    Route::post('/transaction/{uuid}/payment/discount','paymentTransactionDiscount')->name('transaction.payment.discount');
    Route::get('/transaction/{uuid}/payment/receipt/noprice','printCheckReceiptNoPrice')->name('transaction.print.check.noprice');
    Route::get('/transaction/{uuid}/payment/receipt/check','printCheckReceipt')->name('transaction.print.check');
    Route::post('/transaction/{uuid}/payment','proceedPaymentTransaction')->name('transaction.payment.proceed');
    Route::post('/transaction/{uuid}/payment/finalize','finalizePayment')->name('transaction.payment.finalize');
    Route::get('/transaction/{uuid}/payment/receipt','printReceipt')->name('transaction.print.payment');
});

Route::middleware('auth')->controller(ActivityController::class)->group(function() {
    Route::get('/activity','index')->name('activity.index');
    Route::get('/activity/history','history')->name('activity.history');
    Route::get('/activity/report','report')->name('activity.report');
    Route::get('/activity/{date}/report','reportShow')->name('activity.report.show');
});

Route::resource('users',UserController::class)->middleware(IsAdmin::class);
Route::middleware(IsAdmin::class)->controller(UserController::class)->group(function() {
    Route::post('/users/{uuid}/reset','resetPassword')->name('users.reset');
});
