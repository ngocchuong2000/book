 <?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
// Client
Route::namespace('Client')->prefix('/')->group(function () {
    Route::get('', 'HomeController@index')->name('client.home');
    Route::post('/login', 'AuthController@login')->name('auth.post.login');
    Route::post('/register', 'AuthController@register')->name('auth.post.register');
    Route::get('/logout', 'AuthController@logout')->name('auth.logout');
    Route::get('/change-account', 'AuthController@changeAccount')->name('auth.change.account');
    Route::post('/change-account', 'AuthController@postChangeAccount')->name('auth.post.change.account');
    Route::get('/resetpass', 'AuthController@resetPass')->name('auth.resetpass');
    Route::post('/sendlink', 'AuthController@sendLink')->name('auth.sendlink');
    Route::get('/change-password/{token}','AuthController@showChangePassword');
    Route::post('/change-password','AuthController@updatePassword')->name('auth.updatepassword');
    Route::get('/cart', 'OrderController@cart')->name('client.cart');
    Route::get('/products/{id}', 'ProductController@showProducts')->name('products');
    Route::get('/product-category/{id}', 'ProductController@showProductCategory')->name('product.category');
    Route::get('/product-new', 'ProductController@showNewProduct')->name('product.new');
    Route::get('/product-detail/{id}', 'ProductController@showProductDetail')->name('product.detail');
    Route::get('/product-search', 'ProductController@showProductSearch')->name('product.search');
    Route::get('/sort', 'ProductController@sort');
    Route::get('/filter', 'ProductController@filter');
    Route::get('/add-to-cart', 'ProductController@addToCart');
    Route::get('/checkout', 'OrderController@checkout')->name('client.checkout');
    Route::get('/check-voucher', 'OrderController@checkVoucher');
    Route::post('/pay','OrderController@pay')->name('pay');
    Route::get('/cancel-payment-paypal', 'OrderController@cancelPaymentPaypal')->name('cancel.payment.paypal');
    Route::get('/done-payment-paypal', 'OrderController@donePaymentPaypal')->name('done.payment.paypal');
    Route::get('/my-order/{id}','OrderController@showMyOrder')->name('my.order.show');
    Route::get('/delete-item/{id}', 'ProductController@deleteItem')->name('delete.item');
    Route::get('change-qty', 'ProductController@changeQty');
    Route::post('pay','OrderController@pay')->name('pay');
    Route::post('add-comment','CommentController@store')->name('add.comment');
    Route::resource('replies','ReplyController');
    Route::post('rating', 'ProductController@rating');
    Route::get('/add-wishlist', 'ProductController@addWishlist');
    Route::get('/delete-wishlist/{id}', 'ProductController@deleteWishlist')->name('delete.wishlist');
    Route::get('/get-product/{id}', 'ProductController@getProduct');
});

// Admin
Route::namespace('Admin')->prefix('ad')->group(function () {
    Route::get('/', function () {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('admin.form.login');
        }
        return redirect()->route('admin.form.login');
    });
    // Login, logout
    Route::get('/login', 'LoginController@showLoginForm')->name('admin.form.login');
    Route::post('/login', 'LoginController@login')->name('admin.handle.login');
    Route::get('/logout', 'LoginController@logout')->name('admin.handle.logout');
    // Setting
    Route::get('setting','SettingController@index')->name('setting')->middleware('check.role');
    Route::post('setting/{id}','SettingController@update')->name('setting.edit')->middleware('check.role');
    Route::group(['middleware' => 'check.admin.login'], function() {
        // Dashboard
        Route::get('dashboard','DashboardController@index')->name('dashboard');
        Route::get('filter-order', 'DashboardController@fillterOrder')->name('filter.order');
        // Parent Category
        Route::group(['prefix'=>'parent-category','middleware' => 'check.role'],function(){
            Route::get('list','ParentCategoryController@index')->name('parent.category.list');

            Route::get('edit/{id}','ParentCategoryController@edit')->name('parent.category.edit.form');

            Route::post('edit/{id}','ParentCategoryController@update')->name('parent.category.edit');

            Route::get('add','ParentCategoryController@create')->name('parent.category.add.form');

            Route::post('add','ParentCategoryController@store')->name('parent.category.add');

            Route::get('delete/{id}','ParentCategoryController@destroy')->name('parent.category.delete');
        });
        // Category
        Route::group(['prefix'=>'category','middleware' => 'check.role'],function(){
            Route::get('list','CategoryController@index')->name('category.list');

            Route::get('edit/{id}','CategoryController@edit')->name('category.edit.form');

            Route::post('edit/{id}','CategoryController@update')->name('category.edit');

            Route::get('add','CategoryController@create')->name('category.add.form');

            Route::post('add','CategoryController@store')->name('category.add');

            Route::get('delete/{id}','CategoryController@destroy')->name('category.delete');
        });
        // Brand
        Route::group(['prefix'=>'brand','middleware' => 'check.role'],function(){
            Route::get('list','BrandController@index')->name('brand.list');

            Route::get('edit/{id}','BrandController@edit')->name('brand.edit.form');

            Route::post('edit/{id}','BrandController@update')->name('brand.edit');

            Route::get('add','BrandController@create')->name('brand.add.form');

            Route::post('add','BrandController@store')->name('brand.add');

            Route::get('delete/{id}','BrandController@destroy')->name('brand.delete');
        });
        // Supplier
        Route::group(['prefix'=>'supplier','middleware' => 'check.role'],function(){
            Route::get('list','SupplierController@index')->name('supplier.list');

            Route::get('edit/{id}','SupplierController@edit')->name('supplier.edit.form');

            Route::post('edit/{id}','SupplierController@update')->name('supplier.edit');

            Route::get('add','SupplierController@create')->name('supplier.add.form');

            Route::post('add','SupplierController@store')->name('supplier.add');

            Route::get('delete/{id}','SupplierController@destroy')->name('supplier.delete');
        });
        // Author
        Route::group(['prefix'=>'author','middleware' => 'check.role'],function(){
            Route::get('list','AuthorController@index')->name('author.list');

            Route::get('edit/{id}','AuthorController@edit')->name('author.edit.form');

            Route::post('edit/{id}','AuthorController@update')->name('author.edit');

            Route::get('add','AuthorController@create')->name('author.add.form');

            Route::post('add','AuthorController@store')->name('author.add');

            Route::get('delete/{id}','AuthorController@destroy')->name('author.delete');
        });
        // Product
        Route::group(['prefix'=>'product','middleware' => 'check.role'],function(){
            Route::get('list','ProductController@index')->name('product.list');

            Route::get('edit/{id}','ProductController@edit')->name('product.edit.form');

            Route::post('edit/{id}','ProductController@update')->name('product.edit');

            Route::get('add','ProductController@create')->name('product.add.form');

            Route::post('add','ProductController@store')->name('product.add');

            Route::get('delete/{id}','ProductController@destroy')->name('product.delete');

            Route::get('update-status/{id}/{status}','ProductController@updateStatus')->name('product.update.status');

            Route::get('show/{id}','ProductController@show')->name('product.show');
        });
         // Voucher
         Route::group(['prefix'=>'voucher','middleware' => 'check.role'],function(){
            Route::get('list','VoucherController@index')->name('voucher.list');

            Route::get('edit/{id}','VoucherController@edit')->name('voucher.edit.form');

            Route::post('edit/{id}','VoucherController@update')->name('voucher.edit');

            Route::get('add','VoucherController@create')->name('voucher.add.form');

            Route::post('add','VoucherController@store')->name('voucher.add');

            Route::get('delete/{id}','VoucherController@destroy')->name('voucher.delete');
        });
        // Staff
        Route::group(['prefix'=>'staff'],function(){
            Route::get('list','StaffController@index')->name('staff.list')->middleware('check.role');

            Route::get('edit/{id}','StaffController@edit')->name('staff.edit.form')->middleware('check.role');

            Route::post('edit/{id}','StaffController@update')->name('staff.edit')->middleware('check.role');

            Route::get('add','StaffController@create')->name('staff.add.form')->middleware('check.role');

            Route::post('add','StaffController@store')->name('staff.add')->middleware('check.role');

            Route::get('delete/{id}','StaffController@destroy')->name('staff.delete')->middleware('check.role');

            Route::get('change-info/{id}','StaffController@showChangeInfo')->name('staff.change.info');

            Route::post('change-info/{id}','StaffController@changeInfo')->name('staff.post.change.info');

            Route::get('change-pass/{id}','StaffController@showChangePass')->name('staff.change.pass');

            Route::post('change-pass/{id}','StaffController@changePass')->name('staff.post.change.pass');
        });
        // User
        Route::group(['prefix'=>'user','middleware' => 'check.role'],function(){
            Route::get('list','UserController@index')->name('customer.list');

            Route::get('delete/{id}','UserController@destroy')->name('customer.delete');

            Route::get('disable/{id}','UserController@disable')->name('customer.disable');

            Route::get('enable/{id}','UserController@enable')->name('customer.enable');
        });
        // Order
        Route::group(['prefix'=>'order'],function(){
            Route::get('list','OrderController@index')->name('order.list');

            Route::get('show/{id}','OrderController@show')->name('order.show');

            Route::post('edit/{id}','OrderController@update')->name('order.edit');

            Route::get('print/{id}','OrderController@print')->name('order.print');
        });
        // Evaluation
        Route::group(['prefix'=>'evaluation'],function(){
            Route::get('list','EvaluationController@index')->name('evaluation.list');
            Route::get('show/{id}','EvaluationController@show')->name('evaluation.show');
        });
        // Comment
        Route::group(['prefix'=>'comment'],function(){
            Route::get('list','CommentController@index')->name('comment.list');

            Route::get('show/{id}','CommentController@show')->name('comment.show');

            Route::get('delete/{id}','CommentController@destroy')->name('comment.delete');
        });
        // Reply
        Route::group(['prefix'=>'reply'],function(){
            Route::get('delete/{id}','ReplyController@destroy')->name('reply.delete');
        });
        // Rating
        Route::group(['prefix'=>'rating'],function(){
            Route::get('list','RatingController@index')->name('rating.list');
            Route::get('show/{id}','RatingController@show')->name('rating.show');
        });
    });
});
