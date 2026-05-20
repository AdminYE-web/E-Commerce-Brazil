<?php

use App\Http\Controllers\DesignTemplateController;
use App\Http\Controllers\Admin\ProductTemplateController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\AccountAddressController;
use App\Http\Controllers\AccountContactController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountOrderController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\GalleryBannerController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\HomeBannerController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\MaterialHomeController;
use App\Http\Controllers\Admin\OptionDependencyController;
use App\Http\Controllers\Admin\OptionGroupController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\ProductArtworkTemplateController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductDetailController;
use App\Http\Controllers\Admin\ProductListBannerController;
use App\Http\Controllers\Admin\ProductOptionAssignmentController;
use App\Http\Controllers\Admin\ProductOptionController;
use App\Http\Controllers\Admin\ProductOptionVariantController;
use App\Http\Controllers\Admin\ProductPriceRuleController;
use App\Http\Controllers\Admin\ProductPriceTierController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryPageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NewsletterSubscriptionController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductListController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/language/{locale}', [LanguageController::class, 'switch'])
    ->name('language.switch');
Route::post('/newsletter/subscribe', [NewsletterSubscriptionController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('newsletter.subscribe');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('contact.submit');
Route::get('/contact/complete', [ContactController::class, 'complete'])
    ->name('contact.complete');
Route::view('/about-us', 'about')->name('about');

Route::get('/products', [ProductListController::class, 'index'])
    ->name('products.index');
Route::get('/products/description/{code?}', [ProductListController::class, 'description'])
    ->name('products.description');

Route::get('/products/{product}', [ProductListController::class, 'show'])
    ->name('products.show');
Route::get('/hotstrap/{product}', [ProductListController::class, 'showHotstrap'])
    ->name('products.hotstrap.show');

Route::get('/hotmobily/{product}', [ProductListController::class, 'showHotmobily'])
    ->name('products.hotmobily.show');

Route::get('/products/order/{code}', [ProductListController::class, 'order'])
    ->name('products.order');

Route::get('/hotstrap/{product}/detail', [ProductListController::class, 'showHotstrap'])
    ->name('products.hotstrap.show');

Route::get('/hotmobily/{product}/detail', [ProductListController::class, 'showHotmobily'])
    ->name('products.hotmobily.show');
Route::post('/cart/add', [CartController::class, 'add'])
    ->name('cart.add');

Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');
Route::get('/cart/edit/{cartItemId}', [CartController::class, 'edit'])
    ->name('cart.edit');

Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])
    ->name('cart.updateQuantity');

Route::post('/cart/remove', [CartController::class, 'remove'])
    ->name('cart.remove');

Route::get('/checkout', [OrderController::class, 'checkout'])
    ->name('checkout.index');

Route::post('/checkout/upload-artwork', [OrderController::class, 'storeArtworkStep'])
    ->name('checkout.storeArtworkStep');

Route::get('/checkout/address', [OrderController::class, 'address'])
    ->name('checkout.address');

Route::post('/checkout/address', [OrderController::class, 'storeAddressStep'])
    ->name('checkout.storeAddressStep');

Route::get('/checkout/payment', [OrderController::class, 'payment'])
    ->name('checkout.payment');

Route::post('/checkout/payment', [OrderController::class, 'storePaymentStep'])
    ->name('checkout.storePaymentStep');

Route::get('/checkout/review', [OrderController::class, 'review'])
    ->name('checkout.review');

Route::post('/checkout/place-order', [OrderController::class, 'placeOrder'])
    ->name('checkout.placeOrder');

Route::get('/checkout/success/{order}', [OrderController::class, 'success'])
    ->name('checkout.success');

Route::get('/checkout/auth-choice', [CheckoutController::class, 'authChoice'])
    ->name('checkout.authChoice');

Route::get('/checkout/continue-guest', [CheckoutController::class, 'continueGuest'])
    ->name('checkout.continueGuest');

Route::get('/gallery', [GalleryPageController::class, 'index'])
    ->name('gallery.index');

    Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy.policy');

Route::get('/track-order', [OrderTrackingController::class, 'index'])
    ->name('track-order.index');

Route::post('/track-order', [OrderTrackingController::class, 'search'])
    ->name('track-order.search');

Route::get('/track-order/result/{order}', [OrderTrackingController::class, 'result'])
    ->name('track-order.result');
    Route::get('/track-order/result/{order}/receipt', [OrderTrackingController::class, 'downloadReceipt'])
    ->name('track-order.receipt');
    Route::get('/blog', [BlogController::class, 'index'])
    ->name('blog.index');

Route::get('/blog/{article}', [BlogController::class, 'show'])
    ->name('blog.show');
    
    Route::get('/design-template', [DesignTemplateController::class, 'index'])
    ->name('design-template.index');



Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'index'])
        ->name('account.index');

    Route::post('/account/avatar', [AccountController::class, 'updateAvatar'])
        ->name('account.avatar.update');
    Route::put('/account/name', [AccountController::class, 'updateName'])
        ->name('account.name.update');
    Route::put('/account/password', [AccountController::class, 'updatePassword'])
        ->name('account.password.update');
    Route::get('/account/contacts', [AccountContactController::class, 'index'])
        ->name('account.contacts.index');

    Route::get('/account/contacts/create', [AccountContactController::class, 'create'])
        ->name('account.contacts.create');

    Route::post('/account/contacts', [AccountContactController::class, 'store'])
        ->name('account.contacts.store');

    Route::put('/account/contacts/{contact}/main', [AccountContactController::class, 'setMain'])
        ->name('account.contacts.setMain');
    Route::get('/account/contacts/{contact}/edit', [AccountContactController::class, 'edit'])
        ->name('account.contacts.edit');

    Route::put('/account/contacts/{contact}', [AccountContactController::class, 'update'])
        ->name('account.contacts.update');

    Route::delete('/account/contacts/{contact}', [AccountContactController::class, 'destroy'])
        ->name('account.contacts.destroy');
    Route::get('/account/addresses/{type?}', [AccountAddressController::class, 'index'])
        ->name('account.addresses.index');

    Route::get('/account/addresses/{type}/create', [AccountAddressController::class, 'create'])
        ->name('account.addresses.create');

    Route::post('/account/addresses/{type}', [AccountAddressController::class, 'store'])
        ->name('account.addresses.store');

    Route::put('/account/addresses/{address}/main', [AccountAddressController::class, 'setMain'])
        ->name('account.addresses.setMain');
    Route::get('/account/addresses/{address}/edit', [AccountAddressController::class, 'edit'])
        ->name('account.addresses.edit');

    Route::put('/account/addresses/{address}', [AccountAddressController::class, 'update'])
        ->name('account.addresses.update');

    Route::delete('/account/addresses/{address}', [AccountAddressController::class, 'destroy'])
        ->name('account.addresses.destroy');
    Route::get('/account/orders', [AccountOrderController::class, 'index'])
        ->name('account.orders.index');
});

Route::prefix('admin-panel')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [AdminAuthController::class, 'login'])
        ->name('login.submit');

    Route::post('/logout', [AdminAuthController::class, 'logout'])
        ->name('logout');

    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('products', ProductController::class);
        Route::get('products/{product}/options', [ProductOptionAssignmentController::class, 'edit'])
            ->name('products.options.edit');

        Route::put('products/{product}/options', [ProductOptionAssignmentController::class, 'update'])
            ->name('products.options.update');

        Route::resource('product-price-tiers', ProductPriceTierController::class);

        Route::resource('option-groups', OptionGroupController::class);

        Route::resource('product-options', ProductOptionController::class);

        Route::resource('option-dependencies', OptionDependencyController::class);

        Route::resource('product-details', ProductDetailController::class);

        Route::resource('categories', CategoryController::class);
        Route::resource('materials', MaterialController::class);
        Route::resource('product-list-banners', ProductListBannerController::class);

        Route::get('product-options/{option}/variants', [ProductOptionVariantController::class, 'index'])
            ->name('product-options.variants.index');

        Route::get('product-options/{option}/variants/create', [ProductOptionVariantController::class, 'create'])
            ->name('product-options.variants.create');

        Route::post('product-options/{option}/variants', [ProductOptionVariantController::class, 'store'])
            ->name('product-options.variants.store');

        Route::get('product-option-variants/{variant}/edit', [ProductOptionVariantController::class, 'edit'])
            ->name('product-option-variants.edit');

        Route::put('product-option-variants/{variant}', [ProductOptionVariantController::class, 'update'])
            ->name('product-option-variants.update');

        Route::delete('product-option-variants/{variant}', [ProductOptionVariantController::class, 'destroy'])
            ->name('product-option-variants.destroy');

        Route::resource('product-price-rules', ProductPriceRuleController::class);
        Route::resource('product-artwork-templates', ProductArtworkTemplateController::class);
        Route::resource('material-homes', MaterialHomeController::class);
        Route::resource('home-banners', HomeBannerController::class);
        Route::resource('users', UserAdminController::class)->only(['index', 'show']);
        Route::get('orders', [OrderAdminController::class, 'index'])
            ->name('orders.index');

        Route::get('orders/{order}', [OrderAdminController::class, 'show'])
            ->name('orders.show');

        Route::put('orders/{order}/status', [OrderAdminController::class, 'updateStatus'])
            ->name('orders.updateStatus');
        Route::resource('galleries', GalleryController::class);
        Route::resource('gallery-banners', GalleryBannerController::class);
        Route::get('product-price-rules/product-options/{product}', [ProductPriceRuleController::class, 'getProductOptions'])
            ->name('product-price-rules.product-options');
        Route::get('/language/{language}', function ($language) {
            if (! in_array($language, ['pt', 'ja', 'en'])) {
                abort(404);
            }

            session(['admin_product_language' => $language]);

            return back();
        })->name('product-language.switch');
           Route::resource('articles', ArticleController::class);

    Route::post('articles/upload-editor-image', [ArticleController::class, 'uploadEditorImage'])
        ->name('articles.uploadEditorImage');
        Route::resource('product-templates', ProductTemplateController::class);
    });
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPassword'])
        ->name('password.request');

    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetPassword'])
        ->name('password.reset');

    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])
        ->name('password.update');

    // Google OAuth
    Route::get('/auth/google/redirect', [SocialAuthController::class, 'redirectToGoogle'])
        ->name('auth.google.redirect');
    Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])
        ->name('auth.google.callback');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/success', function () {
    return view('auth.verify-success');
})->name('verification.success');

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    /*
    |--------------------------------------------------------------------------
    | 1. Check signed URL / expired link
    |--------------------------------------------------------------------------
    */
    if (! $request->hasValidSignature()) {
        abort(403, 'Invalid or expired verification link.');
    }

    /*
    |--------------------------------------------------------------------------
    | 2. Find user
    |--------------------------------------------------------------------------
    */
    $user = User::where('user_id', $id)->firstOrFail();

    /*
    |--------------------------------------------------------------------------
    | 3. Check hash
    |--------------------------------------------------------------------------
    */
    if (! hash_equals((string) $hash, sha1($user->email))) {
        abort(403, 'Invalid verification link.');
    }

    /*
    |--------------------------------------------------------------------------
    | 4. Prevent using the same verification link again
    |--------------------------------------------------------------------------
    | ถ้า email_verified_at มีค่าแล้ว หรือ status = 1
    | แปลว่าเคย verify ไปแล้ว ห้ามใช้ link ซ้ำ
    |--------------------------------------------------------------------------
    */
    if (! is_null($user->email_verified_at) || (int) $user->status === 1) {
        return redirect()
            ->route('login')
            ->with('message', 'This verification link has already been used. Please login to continue.');
    }

    /*
    |--------------------------------------------------------------------------
    | 5. Verify account
    |--------------------------------------------------------------------------
    */
    $user->forceFill([
        'email_verified_at' => now(),
        'status' => 1,
    ])->save();

    return redirect()->route('verification.success');

})->middleware('signed')->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return redirect('/');
    }

    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'A new verification link has been sent to your email.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
