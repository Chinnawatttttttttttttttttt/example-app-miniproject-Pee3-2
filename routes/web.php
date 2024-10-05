<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\FuncCall;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Assuming 'home' is a named route
Route::get('/', function () {
    return redirect()->action([DashboardController::class, 'ShowProducte']);
});

Route::get('/error', function () {
    return view('error'); // Make sure you have an error.blade.php file in your resources/views directory
});

Route::controller(ProductController::class)->group(function(){

    Route::get('add-product','AddProduct')->middleware('CheckLogin');
    Route::post('/add-product-post','AddProductPost')->name('store.product');

    Route::get('all-product','ShowProduct')->middleware('CheckLogin');

    Route::get('edit-product/{id}','EditProduct')->middleware('CheckLogin');
    Route::post('/update-product','update')->name('product.update');

    Route::delete('/delete-product/{id}','Delete')->name('store.delete');

});
Route::controller(DashboardController::class)->group(function(){

    Route::get('home','ShowProduct')->middleware('CheckLogin');
    Route::post('/submit-data', 'submitData');

    Route::get('homee','ShowProducte')->middleware('CheckLogin');


});

Route::controller(ReportController::class)->group(function(){

    Route::get('report','ShowReportAndTotal')->name('report.all')->middleware('CheckLogin');

    Route::get('reporte','ShowReportAndTotale')->name('report.all')->middleware('CheckLogin');

    Route::get('/download-pdf','downloadPDF')->name('pdf.download');

});

Route::controller(AuthController::class)->group(function(){

    Route::get('login','login')->middleware('NowLogin');
    Route::post('/login-user','loginUser')->name('login.user');

    Route::get('logout','logout')->middleware('CheckLogin');

    Route::get('/add-user','AddUser');
});

Route::middleware(['IsAdmin'])->group(function () {

    Route::get('add-product', [ProductController::class, 'AddProduct']);
    Route::get('all-product', [ProductController::class, 'ShowProduct']);
    Route::get('edit-product/{id}', [ProductController::class, 'EditProduct']);
    Route::get('report', [ReportController::class, 'ShowReportAndTotal']);
    Route::get('home', [DashboardController::class, 'ShowProduct']);

});



