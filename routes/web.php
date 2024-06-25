<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DealsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductRequestController;
use App\Http\Controllers\SellerController;
use App\Models\Product;
use App\Models\ProductRequest;
use Database\Factories\ProductRequestFactory;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\RequestContext;

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

Route::get('/dashboard/login',[AuthController::class,"showlogin"])->name('showlogin');
Route::post('/dashboard/attempt',[AuthController::class,"login"])->name('login');
Route::middleware(['auth'])->group(function(){
   Route::get('/dashboard',[AuthController::class,"home"])->name('home');
Route::get('/dashboard/sellers/create',[SellerController::class,'create'])->name('createSeller');
Route::post('/dashboard/sellers/store',[SellerController::class,'store'])->name('storeSeller');
Route::get('/dashboard/sellers/show/{seller}',[SellerController::class,'show'])->name('showSeller');
Route::get('/dashboard/sellers/edit/{seller}',[SellerController::class,'edit'])->name('editSeller');
Route::put('/dashboard/sellers/update/{seller}',[SellerController::class,'update'])->name('updateSeller');
Route::delete('/dashboard/sellers/delete/{seller}',[SellerController::class,'delete'])->name('deleteSeller');
Route::put('/dashboard/deal/end/{deal}',[DealsController::class,'end'])->name('endDeal');
Route::delete('/dashboard/deal/deny/{deal}',[DealsController::class,'delete'])->name('denyDeal');
Route::get('/dashboard/deals',[DealsController::class,'index'])->name('deals');
Route::get('/dashboard/products/create',[ProductController::class,'create'])->name('addProduct');
Route::get('/dashboard/sellers/search',[SellerController::class,'search'])->name('sellersSearch');
Route::get('/dashboard/sellers',[SellerController::class,'index'])->name('sellers');
Route::get('/dashboard/deals/edit/{deal}',[DealsController::class,'edit'])->name('editDeal');
Route::get('/dashboard/deals/filter',[DealsController::class,'deals'])->name('filterDeals');
Route::put('/dashboard/deals/update/{deal}',[DealsController::class,'update'])->name('updateDeal');
Route::get('/dashboard/products/search',[ProductController::class,'search'])->name('productsSearch');
Route::get('/dashboard/products',[ProductController::class,'index'])->name('products');
Route::get('/dashboard/products/{product}',[ProductController::class,'show'])->name('showProduct');
Route::get('/dashboard/products/edit/{product}',[ProductController::class,'edit'])->name('editProduct');
Route::put('/dashboard/products/update/{product}',[ProductController::class,'update'])->name('updateProduct');
Route::delete('/dashboard/products/delete/{product}',[ProductController::class,'delete'])->name('deleteProduct');
Route::post('/dashboard/products/store',[ProductController::class,'store'])->name('storeProduct');
Route::get('/dashboard/requests/search',[ProductRequestController::class,'search'])->name('requestsSearch');
Route::get('/dashboard/requests',[ProductRequestController::class,'index'])->name('requests');
Route::get('/dashboard/requests/{productRequest}',[ProductRequestController::class,'show'])->name('showRequest');
Route::get('/dashboard/requests/edit/{productRequest}',[ProductRequestController::class,'edit'])->name('editRequest');
Route::put('/dashboard/requests/update/{productRequest}',[ProductRequestController::class,'update'])->name('updateRequest');
Route::delete('/dashboard/requests/delete/{productRequest}',[ProductRequestController::class,'destroy'])->name('deleteRequest');
Route::delete('/dashboard/requests/accept/{productRequest}',[ProductRequestController::class,'accept'])->name('acceptRequest');
Route::delete('/dashboard/requests/accept/{productRequest}',[ProductRequestController::class,'accept'])->name('acceptRequest');
Route::post('/dashboard/logout',[AuthController::class,'logout'])->name('logout');

Route::get('/dashboard/deals/search',[DealsController::class,'search'])->name('dealsSearch');
Route::get('/dashboard/sellers/show/{seller}/deals',[SellerController::class,'deals'])->name('sellerDeals');
Route::get('/dashboard/sellers/show/{seller}/search',[SellerController::class,'dealsSearch'])->name('sellerDealsSearch');

Route::get('/createDeal/{product}',[DealsController::class,'create'])->name('createDeal');
Route::get('/requestProduct',[ProductRequestController::class,'create'])->name('requestProduct');
Route::post('/createDeal/{product}/store',[DealsController::class,'store'])->name('storeDeal');
Route::post('/requestProduct/store',[ProductRequestController::class,'store'])->name('storeRequestedProduct');
Route::get('/',[AuthController::class,'landing'])->name('landing');
Route::get('/sellerDashboard',[AuthController::class,'sellerDashboard'])->name('sellerDashboard');
Route::get('/sellerDashboard/deals',[DealsController::class,'sellerDealsDashboard'])->name('sellerDashboardDeals');
Route::get('/sellerDashboard/requests',[ProductRequestController::class,'sellerRequests'])->name('sellerDashboardRequests');
Route::get('/sellerDashboard/deals/search',[SellerController::class,'sellerDealsSearchDashboard'])->name('sellerDealsSearchDashboard');
Route::get('/sellerDashboard/requests/search',[ProductRequestController::class,'requestsSearch'])->name('requestsSearch');
});