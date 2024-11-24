<?php
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/posts', function(){
//     $token = csrf_token();
//     return view('posts.new');
// })->name('posts');
// Route::post('/posts', function(){
//     return view('posts.new');
// });

Route::post('/profile/photo', [ProfileController::class, 'uploadPhoto'])->name('profile.photo.upload');

Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.view');

Route::resources([
    'posts' => PostController::class,
]);

Route::get('/search', [ProfileController::class, 'showSearchForm'])->name('search.form');   // Show search form
Route::get('/search-results', [ProfileController::class, 'search'])->name('search.results');  // Show search results

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/public_profile', [ProfileController::class, 'showMyProfile'])->name('public_profile.show');
});

require __DIR__.'/auth.php';
