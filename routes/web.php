<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\TicketController;
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
    Route::get('/admin/chat', [AdminController::class, 'getChats'])->middleware(['auth'])->name('admin.chat');
    Route::post('/admin', [AdminController::class, 'postChats'])->middleware(['auth'])->name('admin.chat.post');
    Route::get('/admin/chat/{chat_id}', [AdminController::class, 'showChat'])->middleware(['auth'])->name('admin.chat.show');
    Route::post('/admin/reply', [AdminController::class, 'sendAdminReply'])->middleware(['auth'])->name('admin.reply');
    Route::post('ticket/customer/conversation', [TicketController::class, 'ticketCustomerConv'])->name('ticket.customer.con');
    Route::delete('/delete-ticket/{id?}', [TicketController::class, 'delete'])->name('ticket.delete');

    Route::post('ticket/admin/conversation', [TicketController::class, 'ticketAdminConv'])->name('ticket.admin.con');
    Route::post('ticket/conversation', [TicketController::class, 'ticketConversation'])->name('ticket.conversation');
    Route::post('save-ticket-status', [TicketController::class, 'saveTicketStatus'])->name('save.ticket.status');
    Route::post('save-comment', [TicketController::class, 'saveComment'])->name('save.commet'); 
    Route::post('admin_reply', [TicketController::class, 'adminReply'])->name('save.reply');
    Route::get('/admin/ticket/{id}', [TicketController::class, 'viewTickets'])->middleware(['auth'])->name('admin.ticket.show');
    Route::get('/admin/tickets', [TicketController::class, 'index'])->middleware(['auth'])->name('ticket.list');
});

// User routes here
Route::group(['middleware' => CheckRole::class . ':user'], function () {

    Route::post('/checkResponse', [ChatController::class, 'checkResponse'])->name('checkResponse.chat');
    Route::post('/update-chat-message', [ChatController::class, 'updateChatMessage'])->name('update.chat.message');
    Route::get('/chat', [ChatController::class, 'chat'])->middleware(['auth'])->name('user.chat');
    Route::get('/chatlist', [ChatController::class, 'chatList'])->middleware(['auth'])->name('user.chat.list');
    Route::post('/start-conv', [ChatController::class, 'startConv'])->middleware(['auth'])->name('user.conv');

    Route::post('support-tickets', [TicketController::class, 'addTickets'])->middleware(['auth'])->name('add.tickets');
    Route::get('/raiseticket', [TicketController::class, 'raiseTicket'])->middleware(['auth'])->name('user.raiseTicket');
    Route::get('/tickets', [TicketController::class, 'user_support_tickets'])->middleware(['auth'])->name('user.Tickets');
    Route::get('/tickets/{id?}', [TicketController::class, 'showTicket'])->middleware(['auth'])->name('tickets.show');
    Route::post('ticket/user/conversation', [TicketController::class, 'CusTicketConversation'])->name('ticket.cus.con');
    Route::post('/close-ticket', [TicketController::class, 'closeTicket'])->name('close.ticket');








});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
