<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\RfqController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UnitController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('login');
    }
});

Route::get('/pengajuan', function () {
    return Inertia::render('Pengajuan');
})->name('pengajuan');

Route::get('/page/{page}', function ($page) {
    $items = \App\Models\RfqDetail::leftJoin('products', 'rfq_details.product_id', '=', 'products.id')
        ->leftJoin('tags', 'products.tag', '=', 'tags.slug')
        ->selectRaw('tags.tag_name, SUM(rfq_details.quantity) as total_quantity')
        ->groupBy('tags.id')
        ->get();

    return Inertia::render('Static/'.$page, ['rfqs' => []]);
})->name('page');

Route::get('/updaterole/{role}', function ($role) {
    $user = auth()->user();
    $user->division = $role;
    $user->save();

    // return redirect()->route('dashboard');
})->name('updaterole');

Route::get('/book', function () {
    return Inertia::render('Book');
})->name('book');

if (App::environment('local')) {
    Route::get('/clear-all', function () {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');
        \Illuminate\Support\Facades\Auth::logout();

        return redirect('/');
    });
}

Route::get('auth/redirect/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('auth.redirect');
Route::get('auth/callback/{provider}', [SocialiteController::class, 'handleProviderCallback'])->name('auth.callback');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::resources([
        'brands' => BrandController::class,
        'products' => ProductController::class,
        'room-types' => RoomTypeController::class,
        'suppliers' => SupplierController::class,
        'purchase-orders' => PurchaseOrderController::class,
        'sales-orders' => SalesOrderController::class,
        'rfqs' => RfqController::class,
        'tags' => TagController::class,
        'units' => UnitController::class,
    ]);
});
