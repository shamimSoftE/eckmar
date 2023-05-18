<?php

use App\Http\Controllers\AdministratorLogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\DisputesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\MirrorLinkController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderFeedbackController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WishlistController;
use App\Models\Captcha;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Route;

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
    function custom_captcha()
    {
        $key_gen = "";
        for($i=0; $i < 7; $i++) {
            $key_gen .= range('a', 'z')[mt_rand(0, count(range('a', 'z')) - 1)];
        }
        return $key_gen;
    }
    $captcha = custom_captcha();
    Session()->put('captcha', $captcha);
    return view('auth.login_page');
});



Route::get('/password-forgot', [FrontController::class, 'forgot']);
Route::post('/reset_password', [FrontController::class, 'resetPassword']);

Route::get('/dashboard', function () {
    return redirect('/market-place');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/your-mnemonic-code', [FrontController::class, 'mnemonic']);
    // support ticket for customer
    Route::get('/support', [TicketController::class, 'supportTicket']);
    Route::post('/ticket/create', [TicketController::class, 'support_ticket_create']);
    Route::post('/ticket/send/message', [TicketController::class, 'send_message']);
    Route::post('/ticket/show', [TicketController::class, 'ticket_show']);
    Route::post('/ticket/close', [TicketController::class, 'ticket_close']);


    // support panel
    Route::get('support-panel',[SupportController::class,'supportPanel']);
    Route::get('support-ticket',[SupportController::class,'adminTicket']);
    Route::get('admin/ticket/get_message/{id}',[SupportController::class,'get_message']);
    Route::get('admin/ticket/unread',[SupportController::class,'unread_message']);
    Route::get('admin/ticket/reload_ticket',[SupportController::class,'reload_ticket']);
    Route::post('/ticket/reply/message',[SupportController::class,'reply_message']);



    Route::get('/market-place', [FrontController::class, 'marketplace']);
    Route::get('/vendor-request', [FrontController::class, 'vendor']);
    Route::get('/vendor-dashboard/{id}', [FrontController::class, 'vDashboard']);

    //======================== Seller ===============================================//
    Route::post('/vendor_request_form', [SellerController::class, 'vendorRequest']);
    Route::get('/seller-dashboard', [SellerController::class, 'sallerDashboard']);
    Route::get('/seller-order', [SellerController::class, 'myOrder']);
    Route::post('/order_status', [SellerController::class, 'orderStatus']);
    Route::post('/seller_update', [SellerController::class, 'updateSeller']);

    // wallet
    Route::post('/add-funds', [WalletController::class,'addFunds']);

    // withdraw
    Route::post('seller_balance_withdraw', [WalletController::class, 'withdraw']);

    // product
    Route::get('product_list',[ProductController::class, 'index']);
    Route::get('product_create',[ProductController::class, 'create']);
    Route::get('product_edit/{id}',[ProductController::class, 'edit']);
    Route::post('product_store',[ProductController::class, 'store']);
    Route::post('product_update/{id}',[ProductController::class, 'update']);
    Route::get('autofill_add/{id}',[ProductController::class, 'autofill']);
    Route::post('add_more_autofill/{id}',[ProductController::class, 'updateAutofill']);
    Route::post('product_delete/{id}',[ProductController::class, 'destroy']);


    // product
    Route::get('/products', [FrontController::class, 'productFilter']);
    Route::get('/category-wise/{slug}', [FrontController::class, 'cateWise']);
    Route::get('/product-view/{id}', [FrontController::class, 'productView']);

    // product filete
    Route::get('/product-filter', [ProductController::class, 'filter']);

    // buy produdt
    Route::post('buy_product', [OrderController::class, 'makeOrder']);

    //------------ notification ------------------------
    Route::get('notifications', [NotificationController::class, 'index']);

    // wishlist
    Route::get('wishlist', [WishlistController::class, 'index']);
    Route::get('add_to_wishlist/{id}', [WishlistController::class, 'addWishlist']);
    Route::get('wishlist_remove/{id}', [WishlistController::class, 'destroy']);

    // wallet
    Route::get('wallet',[WalletController::class, 'index']);


    //--------------------------- order status -------------------------------------------
    Route::get('/order-view', [OrderController::class, 'orderView']);

    Route::get('/order-process/{id}', [OrderController::class, 'orderProcess']);
    Route::get('/order-shipped/{id}', [OrderController::class, 'orderDelivered']);
    Route::get('/order-dispute/{id}', [OrderController::class, 'orderDispute']);
    Route::post('/order_cancel/{id}', [OrderController::class, 'orderCancelled']);
    Route::get('/order-complete/{id}', [OrderController::class, 'orderComplete']);

    // dispute order message
    Route::post('send_dispute_sms', [DisputesController::class, 'send_sms']);
    Route::post('get_dispute_message', [DisputesController::class, 'get_dispute_sms']);

    // order feedback
    Route::post('order_feedback', [OrderFeedbackController::class, 'storeFeedback']);
    // Route::get('/auto-delivery', [FrontController::class, 'autoDelivery']);


    // change password
    Route::get('profile/user/{id}', [UserController::class, 'profile']);
    Route::post('change-password', [UserController::class, 'updatePass']);


    // Dashboard======================================================= admin panel

    Route::get('admin-panel', [DashBoardController::class, 'dashboard']);

    // category
    Route::get('category', [CategoryController::class, 'index'])->name('category.index');
    Route::post('category', [CategoryController::class, 'store'])->name('category.store');
    Route::get('category_destroy/{id}', [CategoryController::class, 'destroy']);

    // blog
    Route::get('blog', [NewsController::class, 'index']);
    Route::post('blog_store', [NewsController::class, 'store']);
    Route::post('blog_edit', [NewsController::class, 'edit']);
    Route::post('blog_update', [NewsController::class, 'update']);
    Route::post('blog_delete/{id}', [NewsController::class, 'destroy']);

    // mirror links
    Route::get('mirror_link', [MirrorLinkController::class, 'index']);
    Route::post('mirror_link_store', [MirrorLinkController::class, 'store']);
    Route::post('mirror_link_edit', [MirrorLinkController::class, 'edit']);
    Route::post('mirror_link_update', [MirrorLinkController::class, 'update']);
    Route::post('mirror_link_delete/{id}', [MirrorLinkController::class, 'destroy']);

    // user list
    Route::get('user_list', [UserController::class, 'userList']);
    Route::post('user_filter', [UserController::class, 'userFilter']);
    Route::get('user_details/{id}', [UserController::class, 'userDetail']);

    // user panel permission
    Route::post('user_permission/', [UserController::class, 'userPermission'])->name('user_permission');

    // user wallet modify
    Route::post('user_wallet_modify/', [UserController::class, 'userWalletModify'])->name('user_wallet_modify');

    // user banned
    Route::post('user_banned/', [UserController::class, 'userBanned'])->name('user.banned');

    // administrator
    Route::get('administrator_log', [AdministratorLogController::class, 'index']);

    // admin product list
    Route::get('admin_product_list', [ProductController::class, 'adminProductLlst']);
    Route::post('admin_product_list', [ProductController::class, 'adminProductFilter'])->name('adminProFilter');
    Route::get('admin_product_edit/{id}', [ProductController::class, 'adminProductEdit']);
    Route::post('admin_product_update/{id}', [ProductController::class, 'adminProductUpdate']);
    Route::post('admin_product_delete/{id}', [ProductController::class, 'adminProductDelete']);

    // all order
    Route::get('orders', [DashBoardController::class, 'adminOrder']);

    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
