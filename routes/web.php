<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [ProjectController::class,'index'])->name('home');


Route::get('/single_product', function(){
    ///IF A USER TRIES TO ACCESS THE SINGLE PRODUCT PAGE WITHOUT PASSSING AN ID
    ///IT WILL REDIRECT TO THE HOME PAGE
    return redirect('/'); 

});


Route::get('/products', [ProjectController::class,'products'])->name('products');


Route::get('/about', function(){
    return view('about');
})->name('about');

Route::get('/single_product/{id}', [ProjectController::class, 'single_product'])->name('single.product');

Route::get('/cart', [CartController::class, 'cart'])->name('cart');


Route::post('/add_to_cart', [CartController::class, 'add_to_cart'])->name('add_to_cart');
Route::get('/add_to_cart', function(){
    return redirect('/');
});


Route::post('/remove_from_cart', [CartController::class, 'remove_from_cart'])->name('remove_from_cart');
Route::get('/remove_from_cart', function(){
    return redirect('/');
});



Route::post('/edit_product_quantity', [CartController::class, 'edit_product_quantity'])->name('edit_product_quantity');
Route::get('/edit_product_quantity', function(){
    return redirect('/');
});


Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');

Route::post('/place_order', [CartController::class, 'place_order'])->name('place_order');



Route::get('/payment', [PaymentController::class, 'payment'])->name('payment');


// START ROUTE FOR PAYSTACK Laravel 8 & 9
Route::post('/pay', [App\Http\Controllers\PaymentController::class, 'redirectToGateway'])->name('pay');

Route::get('/payment/callback', 'PaymentController@handleGatewayCallback');

// END ROUTE FOR PAYSTACK Laravel 8 & 9








Route::get('/thank_you', [PaymentController::class, 'thank_you'])->name('thank_you');