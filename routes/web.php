<?php
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('posts.feed');
    }
    return redirect()->route('login');
});

Route::post('/users/{id}/follow', [ProfileController::class, 'toggleFollow'])->name('users.follow');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route::get('/posts', function(){
//     $token = csrf_token();
//     return view('posts.new');
// })->name('posts');
// Route::post('/posts', function(){
//     return view('posts.new');
// });

Route::post('/profile/photo', [ProfileController::class, 'uploadPhoto'])->name('profile.photo.upload');

Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.view');


//Route::get('/feed', [PostController::class, 'feed'])->name('posts.feed');
Route::middleware('auth')->get('/feed', [ProfileController::class, 'feed'])->name('posts.feed');


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
    
    // Likes
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like');
    
    // Comments
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Messages / Direct Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/unread-count', [MessageController::class, 'unreadCount'])->name('messages.unread');
    Route::get('/messages/new/{user}', [MessageController::class, 'create'])->name('messages.create');
    Route::get('/messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{conversation}/new', [MessageController::class, 'getNewMessages'])->name('messages.new');
});

require __DIR__.'/auth.php';
