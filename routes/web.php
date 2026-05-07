<?php
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\ProductOptionVariantController;
use App\Http\Controllers\Admin\ProductOptionAssignmentController;
use App\Http\Controllers\Admin\ProductListBannerController;
use App\Http\Controllers\Admin\OptionDependencyController;
use App\Http\Controllers\Admin\OptionGroupController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductOptionController;
use App\Http\Controllers\Admin\ProductPriceTierController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\ProductDetailController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\ProductListController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/language/{locale}', [LanguageController::class, 'switch'])
    ->name('language.switch');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('contact.submit');
Route::get('/contact/complete', [ContactController::class, 'complete'])
    ->name('contact.complete');

Route::get('/products', [ProductListController::class, 'index'])
    ->name('products.index');
    Route::get('/products/{product}/description', [ProductListController::class, 'description'])
    ->name('products.description');
    

Route::get('/products/{product}', [ProductListController::class, 'show'])
    ->name('products.show');
    Route::get('/hotstrap/{product}', [ProductListController::class, 'showHotstrap'])
    ->name('products.hotstrap.show');
    

Route::get('/hotmobily/{product}', [ProductListController::class, 'showHotmobily'])
    ->name('products.hotmobily.show');

    Route::get('/hotstrap/{product}/detail', [ProductListController::class, 'showHotstrap'])
    ->name('products.hotstrap.show');

Route::get('/hotmobily/{product}/detail', [ProductListController::class, 'showHotmobily'])
    ->name('products.hotmobily.show');
Route::post('/cart/add', [CartController::class, 'add'])
    ->name('cart.add');

Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');


Route::prefix('admin')->name('admin.')->group(function () {
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
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

 Route::get('/email/verify/success', function () {
    return view('auth.verify-success');
})->name('verification.success');


Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    if (! $request->hasValidSignature()) {
        abort(403, 'Invalid or expired verification link.');
    }

    $user = User::where('user_id', $id)->firstOrFail();

    if (! hash_equals((string) $hash, sha1($user->email))) {
        abort(403, 'Invalid verification link.');
    }

    if (is_null($user->email_verified_at)) {
        $user->forceFill([
            'email_verified_at' => now(),
            'status' => 1,
        ])->save();
    } else {
        $user->update([
            'status' => 1,
        ]);
    }

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

