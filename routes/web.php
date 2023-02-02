<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Item\Itemcontroller;
use App\Http\Controllers\Admin\Admincontroller;
use App\Http\Controllers\Stock\Stockcontroller;
use App\Http\Controllers\itemin\Itemincontroller;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Vendor\Vendorcontroller;
use App\Http\Controllers\Item_out\Itemoutcontroller;
use App\Http\Controllers\Dashboard\Dashboardcontroller;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\incomingitem\Incomingitemcontroller;

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

Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('auth.login');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [Dashboardcontroller::class, 'index'])->name('dashboard');

    // ADMIN
    Route::get('/dashboard/admin', [Admincontroller::class, 'index'])->name('dashboard.admin');
    Route::get('/dashboard/admin/vendor', [Admincontroller::class, 'vendor_view'])->name('dashboard.admin.vendor');
    Route::get('/vendor/query/tampil', [Admincontroller::class, 'query_vendor']);
    Route::post('/submit/new-vendor', [Admincontroller::class, 'submit_vendor'])->name('simpan.vendor');
    Route::post('/vendor/delete/{id}', [Admincontroller::class, 'delete_vendor']);
    Route::get('/vendor/detail/{id}', [Admincontroller::class, 'detail_vendor'])->name('vendor.detail');
    Route::post('/vendor/update', [Admincontroller::class, 'update'])->name('vendor.update');
    Route::post('/vendor/update-vendor', [Admincontroller::class, 'updateData'])->name('vendor.update.vendor');
    Route::delete('/vendor/destroy/{id}', [Admincontroller::class, 'delete_vendor'])->name('vendor.destroy');
    // ITEM IN
    Route::get('/incoing-item/index', [Itemincontroller::class, 'index'])->name('incoming.item.index');
    Route::get('/itemin/get-data', [Itemincontroller::class, 'get_data'])->name('itemin.get_data');
    Route::post('/itemin/store', [Itemincontroller::class, 'store_data'])->name('itemin.store');
    Route::delete('/item/destroy/{id}', [Itemincontroller::class, 'destroy'])->name('itemin.destroy');
    Route::post('/get-update-data', [Itemincontroller::class, 'update_itemin'])->name('item.to .update');
    Route::post('/get-update-data/proses', [Itemincontroller::class, 'proses_update'])->name('item.to.update.proses');
    Route::get('/itemin/vendor_id/item_id/{vendor_id}/{item_id}', [Itemincontroller::class, 'get_on_vendor_and_item']);

    // ITEM OUT
    Route::get('/out-item/index', [Itemoutcontroller::class, 'index'])->name('itemout');
    Route::get('/out-item/get-data', [Itemoutcontroller::class, 'get_data'])->name('itemout.get_data');
    Route::post('/vendor/data', [Itemoutcontroller::class, 'getdata_by_vendor'])->name('vendor.on_id');
    Route::post('/vendor/data/by-vendor-and-item', [Itemoutcontroller::class, 'get_databy_vendor_and_item_id'])->name('vendor.on.vendorid.and.itemid');
    Route::post('/out-item/save', [Itemoutcontroller::class, 'store'])->name('itemsout.store');

    // ITEM
    Route::get('/all-item/get', [Itemcontroller::class, 'index'])->name('item');
    Route::get('/item/get', [Itemcontroller::class, 'get_data'])->name('item.all.data');
    Route::get('/item/vendor_id/item_id/{vendor_id}/{item_id}', [Itemcontroller::class, 'get_on_vendor_and_item']);
    Route::post('/item/store', [Itemcontroller::class, 'store'])->name('item.store.data');
    Route::post('/get-item/by-id', [Itemcontroller::class, 'get_by_id'])->name('item.get.by.id');
    Route::post('/item/update-proses', [Itemcontroller::class, 'update'])->name('item.update.proses');

    // STOCK
    Route::get('/stock/index', [Stockcontroller::class, 'index'])->name('stock');
    Route::get('/stock/get_data', [Stockcontroller::class, 'get_data'])->name('stock.data');
    Route::get('/stock/vendor_id/item_id/{vendor_id}/{item_id}', [Stockcontroller::class, 'get_on_vendor_and_item']);

    // REPORT
    Route::get('/report', [ReportController::class, 'index'])->name('report');
    Route::get('/report/detail/{category}', [ReportController::class, 'detail'])->name('report.detail');
    Route::get('/report/to_print/{category}', [ReportController::class, 'to_print'])->name('report.to_print');
});

require __DIR__ . '/auth.php';
