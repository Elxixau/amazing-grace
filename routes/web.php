<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\QrAccessController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\TicketSettingController;
use App\Http\Controllers\Admin\RouteLogController;



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

Route::get('/', [OrderController::class, 'home'])->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Dashboard protected by auth
Route::middleware(['auth', 'role:superadmin,admin'])->prefix('admin')->name('admin.')->group(function () {

    // Semua admin & superadmin bisa akses dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Hanya superadmin
    Route::middleware('role:superadmin')->group(function () {
        Route::prefix('users')->name('user.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::delete('/{id}', [UserController::class, 'delete'])->name('delete');
        });

        Route::prefix('logs')->name('log.')->group(function () {
            Route::get('/', [RouteLogController::class, 'index'])->name('index');
            Route::delete('/clear', [RouteLogController::class, 'delete'])->name('clear');
        });
    });

    // Admin dan superadmin
    Route::prefix('tickets')->name('ticket.')->group(function () {
        Route::get('/', [TicketController::class, 'index'])->name('index');
        Route::get('/{ticket_id}/detail', [TicketController::class, 'edit'])->name('edit');
        Route::put('/{ticket_id}', [TicketController::class, 'update'])->name('update');
        Route::post('/', [TicketController::class, 'store'])->name('store');
        Route::delete('/{ticket_id}', [TicketController::class, 'delete'])->name('delete');
        Route::get('/scan', [QrAccessController::class, 'scanner'])->name('scan');
        Route::post('/mark-scanned/{id}', [QrAccessController::class, 'markAsScanned'])->name('qr.mark');
        Route::get('/scanned/{id}', [QrAccessController::class, 'redirectAfterScan'])->name('qr.redirect');
        Route::get('/settings', [TicketSettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [TicketSettingController::class, 'store'])->name('settings.store');
        Route::delete('/settings/{id}', [TicketSettingController::class, 'delete'])->name('settings.delete');
    });

    // Operator juga boleh akses post
    Route::middleware('role:superadmin,admin,operator')->prefix('posts')->name('post.')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/', [PostController::class, 'store'])->name('store');
        Route::get('/{slug}/edit', [PostController::class, 'edit'])->name('edit');
        Route::put('/{slug}', [PostController::class, 'update'])->name('update');
        Route::delete('/{slug}', [PostController::class, 'destroy'])->name('destroy');
        Route::get('/guest-star-template/{index}', function ($index) {
            return view('admin.posts.partials.guest_star', ['index' => $index]);
        })->name('guest_template');
        Route::patch('/{slug}/toggle-show', [PostController::class, 'toggleShow'])->name('toggle-show');
    });
});


Route::get('/booking', [orderController::class, 'create'])->name('create');
Route::post('/booking/order', [orderController::class, 'store'])->name('tiket.store');