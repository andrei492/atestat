<?php
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SavedPostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// Serve storage files directly (workaround for Railway symlink issues)
Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    
    if (!file_exists($fullPath)) {
        abort(404);
    }
    
    $mimeType = mime_content_type($fullPath);
    return response()->file($fullPath, ['Content-Type' => $mimeType]);
})->where('path', '.*')->name('storage.serve');

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('posts.feed');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// All authenticated routes
Route::middleware('auth')->group(function () {
    // Follow (rate limited)
    Route::post('/users/{id}/follow', [ProfileController::class, 'toggleFollow'])
        ->middleware('throttle:follows')
        ->name('users.follow');
    
    // Profile photo upload
    Route::post('/profile/photo', [ProfileController::class, 'uploadPhoto'])->name('profile.photo.upload');
    
    // View profiles (auth required to see other users)
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.view');
    
    // Feed
    Route::get('/feed', [ProfileController::class, 'feed'])->name('posts.feed');
    
    // Posts - only create/store/edit/update/destroy require auth, show is public
    Route::resource('posts', PostController::class)->except(['index'])->middleware('throttle:posts');
    
    // Search
    Route::get('/search', [ProfileController::class, 'showSearchForm'])->name('search.form');
    Route::get('/search-results', [ProfileController::class, 'search'])->name('search.results');
    
    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/public_profile', [ProfileController::class, 'showMyProfile'])->name('public_profile.show');
    
    // Likes
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like');
    
    // Comments (rate limited)
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
        ->middleware('throttle:comments')
        ->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Messages / Direct Messages (rate limited)
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/unread-count', [MessageController::class, 'unreadCount'])->name('messages.unread');
    Route::get('/messages/search-users', [MessageController::class, 'searchUsers'])->name('messages.search-users');
    Route::get('/messages/suggested-users', [MessageController::class, 'getSuggestedUsers'])->name('messages.suggested-users');
    Route::post('/messages/share-post', [MessageController::class, 'sharePost'])
        ->middleware('throttle:messages')
        ->name('messages.share-post');
    Route::get('/messages/new/{user}', [MessageController::class, 'create'])->name('messages.create');
    Route::get('/messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}', [MessageController::class, 'store'])
        ->middleware('throttle:messages')
        ->name('messages.store');
    Route::get('/messages/{conversation}/new', [MessageController::class, 'getNewMessages'])->name('messages.new');

    // Saved Posts
    Route::post('/posts/{post}/save', [SavedPostController::class, 'toggle'])->name('posts.save');
    Route::get('/saved', [SavedPostController::class, 'index'])->name('saved.index');
});

require __DIR__.'/auth.php';
