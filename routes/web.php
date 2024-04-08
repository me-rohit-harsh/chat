<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Middleware\CheckRole;
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

// Admin routes here
Route::group(['middleware' => CheckRole::class . ':admin'], function () {
    Route::get('/admin', [AdminController::class, 'getChats'])->middleware(['auth'])->name('admin.chat');
    Route::post('/admin', [AdminController::class, 'postChats'])->middleware(['auth'])->name('admin.chat.post');
    Route::get('/admin/chat/{chat_id}', [AdminController::class, 'showChat'])->middleware(['auth'])->name('admin.chat.show');
    Route::post('/admin/reply', [AdminController::class, 'sendAdminReply'])->middleware(['auth'])->name('admin.reply');
});

// User routes here
Route::group(['middleware' => CheckRole::class . ':user'], function () {
    Route::post('/update-chat-message/{id}', [ChatController::class, 'updateChatMessage'])->name('update.chat.message');
    Route::get('/chat', [ChatController::class, 'chat'])->middleware(['auth'])->name('user.chat');
    Route::get('/chatlist', [ChatController::class, 'chatList'])->middleware(['auth'])->name('user.chat.list');
    Route::post('/start-conv', [ChatController::class, 'startConv'])->middleware(['auth'])->name('user.conv');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
