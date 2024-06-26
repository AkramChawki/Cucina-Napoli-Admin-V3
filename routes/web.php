<?php

use App\Models\Fiche;
use App\Models\Order;
use App\Models\Product;
use App\Models\Rubrique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Carbon;

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

Route::get('/', function () {
    return  redirect("/admin");
});

Route::get('/print-receipt/{pdf}',function ($pdf) {
    $url = "https://restaurant.cucinanapoli.com/storage/receipt/{$pdf}";
    return view('print', ['url' => $url]);
})->name('print.receipt');;

// Route::get('/test', function () {
//     $today = Carbon::today();
//     $dailyTotalPrice = Order::whereDate('created_at', $today)->sum('total');
//     return $dailyTotalPrice;
// });
