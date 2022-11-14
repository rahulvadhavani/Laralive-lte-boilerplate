<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\{Profile,Dashboard,StaticPage};
use App\Http\Livewire\Admin\Category\{Category};
use App\Http\Livewire\Admin\Blog\Blogs;
use App\Http\Livewire\Admin\User\Users;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Artisan;

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
    return view('welcome');
})->name('home');


Route::group(['prefix' => 'admin'],function(){
    Auth::routes(['register' => false]);
});

Route::group(['prefix' => 'admin','middleware' => ['auth','admin']],function(){
    Route::get('logout', [LoginController::class,'logout'])->name('admin.logout');
    Route::get('users',Users::class)->name('users');
    Route::get('category',Category::class)->name('category');
    Route::get('blogs',Blogs::class)->name('blogs');
    Route::get('dashboard', Dashboard::class)->name('dashboard');
    Route::get('profile', Profile::class)->name('profile');
    Route::get('static-page/{slug}', StaticPage::class)->name('static-page');
    Route::get('clear-cache', function () {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:cache');
        Artisan::call('key:generate');
        return "Cache is cleared";
    });
});
Route::post('ck-image-upload', function(){
    $path = 'images/ck-images/';
    $url=  imageUploader(request()->upload,$path,$isUrl = true);
    $CKEditorFuncNum = request()->input('CKEditorFuncNum');
    return response()->json(['fileName' => basename($url), 'uploaded'=> 1, 'url' => $url]);
})->name('ck-image-upload')->middleware('admin')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);


// Route::view('/', 'home')->name('home');








