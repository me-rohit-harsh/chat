<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

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
    return view('index');
});

Route::get('/chat', [ChatController::class, 'chat'])->name('user.chat');

Route::post('/start-conv', [ChatController::class, 'startConv'])->name('user.conv');

Route::get('/admin', [AdminController::class, 'getChats'])->name('admin.chat');
Route::post('/admin', [AdminController::class, 'postChats'])->name('admin.chat.post');
Route::get('/admin/chat/{chat_id}', [AdminController::class, 'showChat'])->name('admin.chat.show');
Route::post('/admin/reply', [AdminController::class, 'sendAdminReply'])->name('admin.reply');
