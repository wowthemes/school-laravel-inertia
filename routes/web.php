<?php

use App\Http\Controllers\AttachmentsController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\UsersController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/students', [StudentsController::class, 'index'])->middleware('auth', 'verified')->name('students.index');

Route::prefix('users')->controller(UsersController::class)->name('users.')->middleware(['auth', 'verified'])->group(function() {
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/edit/{user:id}', 'edit')->name('edit');
    Route::patch('/update/{user:id}', 'update')->name('update');
    Route::delete('/delete/{user:id}', 'delete')->name('delete');
    Route::get('/', 'index')->name('index');
});

Route::prefix('attachments')->controller(AttachmentsController::class)->name('attachments.')->middleware(['auth', 'verified'])->group(function() {
    // Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    // Route::get('/edit/{attachment:id}', 'edit')->name('edit');
    Route::patch('/update/{attachment:id}', 'update')->name('update');
    Route::get('/', 'index')->name('index');
});

require __DIR__.'/auth.php';
