# Project Documentation - Social Media Platform

## Table of Contents
1. [Project Overview](#project-overview)
2. [Architecture](#architecture)
3. [Database Design](#database-design)
4. [API Documentation](#api-documentation)
5. [Authentication System](#authentication-system)
6. [File Upload System](#file-upload-system)
7. [Like System](#like-system)
8. [Comment System](#comment-system)
9. [Frontend Components](#frontend-components)
10. [UI Design System](#ui-design-system)
11. [Backend Controllers](#backend-controllers)
12. [Security Considerations](#security-considerations)
13. [Performance Optimization](#performance-optimization)
14. [Testing Strategy](#testing-strategy)
15. [Deployment Guide](#deployment-guide)
16. [Changelog](#changelog)

---

## Project Overview

### Purpose
This social media platform is a Laravel-based web application designed to demonstrate modern web development practices. It provides core social media functionality including user authentication, image posting, following system, and personalized feeds.

### Target Audience
- Students learning web development
- Developers looking for Laravel social media implementation examples
- Anyone interested in modern PHP web application architecture

### Key Features
- User registration and authentication
- Profile management with photo uploads
- Image posting with validation
- Following/unfollowing system
- **Like system** - Users can like/unlike posts
- **Comment system** - Users can comment on posts
- Personalized feed generation
- User search functionality
- **Modern dark theme UI** with purple accents
- Responsive design

---

## Architecture

### MVC Pattern
The application follows Laravel's MVC (Model-View-Controller) architecture:

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│     Models      │    │   Controllers   │    │     Views       │
│                 │    │                 │    │                 │
│ - User.php      │◄──►│ - PostController│◄──►│ - Blade         │
│ - Post.php      │    │ - ProfileCntrl  │    │   Templates     │
│ - Follower.php  │    │ - LikeController│    │ - Components    │
│ - Like.php      │    │ - CommentCntrl  │    │                 │
│ - Comment.php   │    │ - AuthCntrl     │    │                 │
└─────────────────┘    └─────────────────┘    └─────────────────┘
```

### Directory Structure
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/                 # Authentication controllers
│   │   ├── PostController.php    # Post management
│   │   ├── ProfileController.php # Profile & following logic
│   │   ├── LikeController.php    # Like/unlike functionality
│   │   └── CommentController.php # Comment management
│   └── Requests/
│       ├── Auth/                 # Authentication requests
│       └── ProfileUpdateRequest.php
├── Models/
│   ├── User.php                  # User model with relationships
│   ├── Post.php                  # Post model with likes/comments
│   ├── Follower.php              # Following relationships
│   ├── Like.php                  # Like model
│   └── Comment.php               # Comment model
└── View/
    └── Components/               # Blade components
```

---

## Database Design

### Entity Relationship Diagram
```
Users (id, name, email, password, profile_photo, timestamps)
  │
  ├── 1:N ──► Posts (id, author_id, image_path, timestamps)
  │             │
  │             ├── 1:N ──► Likes (id, user_id, post_id, timestamps)
  │             │
  │             └── 1:N ──► Comments (id, user_id, post_id, body, timestamps)
  │
  └── M:N ──► Followers (id, follower_id, following_id, timestamps)
```

### Table Specifications

#### Users Table
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    profile_photo VARCHAR(255) NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

#### Posts Table
```sql
CREATE TABLE posts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    author_id BIGINT UNSIGNED NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
);
```

#### Followers Table
```sql
CREATE TABLE followers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    follower_id BIGINT UNSIGNED NOT NULL,
    following_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (follower_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (following_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_follow (follower_id, following_id)
);
```

#### Likes Table
```sql
CREATE TABLE likes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    post_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    UNIQUE KEY unique_like (user_id, post_id)
);
```

#### Comments Table
```sql
CREATE TABLE comments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    post_id BIGINT UNSIGNED NOT NULL,
    body TEXT NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);
```

### Database Relationships

#### User Model Relationships
```php
// User has many posts
public function posts()
{
    return $this->hasMany(Post::class, 'author_id');
}

// User followers (users who follow this user)
public function followers()
{
    return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id');
}

// User following (users this user follows)
public function following()
{
    return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id');
}
```

#### Post Model Relationships
```php
// Post belongs to a user
public function user()
{
    return $this->belongsTo(User::class, 'author_id');
}

// Post has many likes
public function likes()
{
    return $this->hasMany(Like::class);
}

// Post has many comments
public function comments()
{
    return $this->hasMany(Comment::class);
}

// Check if post is liked by a user
public function isLikedBy($user)
{
    if (!$user) return false;
    return $this->likes()->where('user_id', $user->id)->exists();
}
```

#### Like Model Relationships
```php
// Like belongs to a user
public function user()
{
    return $this->belongsTo(User::class);
}

// Like belongs to a post
public function post()
{
    return $this->belongsTo(Post::class);
}
```

#### Comment Model Relationships
```php
// Comment belongs to a user
public function user()
{
    return $this->belongsTo(User::class);
}

// Comment belongs to a post
public function post()
{
    return $this->belongsTo(Post::class);
}
```

---

## API Documentation

### Authentication Routes
```php
// Public routes
POST /login           # User login
POST /register        # User registration
POST /password/reset  # Password reset

// Protected routes
POST /logout          # User logout
GET  /profile         # View profile
PATCH /profile        # Update profile
DELETE /profile       # Delete account
```

### Post Routes
```php
GET    /posts/create   # Show create post form
POST   /posts          # Store new post
GET    /posts/{id}     # Show specific post
PUT    /posts/{id}     # Update post (not implemented)
DELETE /posts/{id}     # Delete post (not implemented)
```

### Profile Routes
```php
GET  /profile/{id}           # View user profile
POST /profile/photo          # Upload profile photo
GET  /public_profile         # View own profile
POST /users/{id}/follow      # Follow/unfollow user
```

### Feed and Search Routes
```php
GET /feed                    # View personalized feed
GET /search                  # Show search form
GET /search-results          # Search results
```

### Like Routes
```php
POST /posts/{post}/like      # Toggle like on a post (auth required)
```

### Comment Routes
```php
POST   /posts/{post}/comments  # Add comment to a post (auth required)
DELETE /comments/{comment}     # Delete a comment (auth required)
```

---

## Authentication System

### Laravel Breeze Integration
The application uses Laravel Breeze for authentication, providing:

- **Registration**: Email-based user registration
- **Login**: Email/password authentication
- **Password Reset**: Email-based password recovery
- **Email Verification**: Optional email verification
- **Session Management**: Secure session handling

### Authentication Flow
```
1. User Registration
   ├── Validation (email, password, name)
   ├── Password hashing
   ├── User creation
   └── Automatic login

2. User Login
   ├── Credential validation
   ├── Session creation
   └── Redirect to dashboard

3. Password Reset
   ├── Email verification
   ├── Token generation
   ├── Reset link email
   └── Password update
```

### Middleware Protection
```php
// Protected routes use auth middleware
Route::middleware('auth')->group(function () {
    Route::get('/feed', [ProfileController::class, 'feed']);
    Route::get('/profile', [ProfileController::class, 'edit']);
    // ... other protected routes
});
```

---

## File Upload System

### Image Upload Implementation
```php
// PostController::store()
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'upload_file' => [
            'required',
            File::image()->max(12 * 1024), // 12MB max
        ],
    ]);

    if ($validator->fails()) {
        return redirect(route('posts.create'))
                    ->withErrors($validator)
                    ->withInput();
    }

    $filePath = $request->file('upload_file')
                       ->store('uploads/' . auth()->id(), 'public');
    
    Post::create([
        'image_path' => $filePath,
        'author_id' => auth()->id(),
    ]);
}
```

### File Storage Structure
```
storage/
└── app/
    └── public/
        └── uploads/
            ├── 1/              # User ID 1 uploads
            │   ├── post1.jpg
            │   └── profile.jpg
            └── 2/              # User ID 2 uploads
                ├── post1.png
                └── post2.jpg
```

### Security Measures
- **File Type Validation**: Only image files allowed
- **Size Restrictions**: Maximum 12MB per upload
- **User-Specific Directories**: Files organized by user ID
- **Proper File Permissions**: Secure file storage
- **Input Sanitization**: Validation before processing

---

## Like System

### Overview
The like system allows users to like and unlike posts. It features both traditional form submission and AJAX-based interactions for a smoother user experience.

### Like Model
```php
// app/Models/Like.php
class Like extends Model
{
    protected $fillable = [
        'user_id',
        'post_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
```

### LikeController Implementation
```php
// app/Http/Controllers/LikeController.php
public function toggle(Post $post)
{
    $user = auth()->user();
    
    $existingLike = Like::where('user_id', $user->id)
                        ->where('post_id', $post->id)
                        ->first();

    if ($existingLike) {
        $existingLike->delete();
        $liked = false;
    } else {
        Like::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
        $liked = true;
    }

    // Return JSON for AJAX requests
    if (request()->expectsJson()) {
        return response()->json([
            'liked' => $liked,
            'count' => $post->likes()->count(),
        ]);
    }

    return back();
}
```

### Frontend Integration
The like button uses AJAX for seamless interaction:
```javascript
// Handle like forms with AJAX
document.querySelectorAll('.like-form').forEach(form => {
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const response = await fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        // Update UI based on response
    });
});
```

### Features
- Toggle like/unlike with single click
- Visual feedback (filled heart when liked)
- Real-time like count updates
- AJAX support with fallback to form submission
- Unique constraint prevents duplicate likes

---

## Comment System

### Overview
The comment system allows users to add comments to posts and delete their own comments. Post owners can also delete comments on their posts.

### Comment Model
```php
// app/Models/Comment.php
class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'post_id',
        'body',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
```

### CommentController Implementation
```php
// app/Http/Controllers/CommentController.php

// Store a new comment
public function store(Request $request, Post $post)
{
    $validator = Validator::make($request->all(), [
        'body' => 'required|string|max:1000',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    $comment = Comment::create([
        'user_id' => auth()->id(),
        'post_id' => $post->id,
        'body' => $request->body,
    ]);

    return back();
}

// Delete a comment
public function destroy(Comment $comment)
{
    // Only allow comment owner or post owner to delete
    if (auth()->id() !== $comment->user_id && 
        auth()->id() !== $comment->post->author_id) {
        abort(403);
    }

    $comment->delete();
    return back();
}
```

### Comment Display
Comments are displayed on the post detail page with:
- User profile picture
- Username with link to profile
- Comment text
- Timestamp
- Delete button (for owner/post author)

### Features
- Add comments with validation (max 1000 characters)
- View all comments on post detail page
- Comments count preview on feed
- Delete own comments
- Post owners can delete any comment on their posts
- Eager loading for performance

---

## Frontend Components

### Blade Templates Structure
```
resources/views/
├── layouts/
│   ├── app.blade.php           # Main application layout
│   ├── guest.blade.php         # Guest user layout
│   └── navigation.blade.php    # Navigation component
├── components/
│   ├── primary-button.blade.php
│   ├── text-input.blade.php
│   └── modal.blade.php
├── posts/
│   ├── feed.blade.php          # Social media feed
│   ├── new.blade.php           # Create post form
│   └── show.blade.php          # Individual post view
├── users/
│   ├── profile.blade.php       # User profile view
│   ├── search.blade.php        # User search form
│   └── search-results.blade.php
└── auth/
    ├── login.blade.php
    ├── register.blade.php
    └── forgot-password.blade.php
```

### CSS Organization
```
public/css/
├── styles_posts_on_feed.css        # Feed styling
├── styles_posts_on_profile_page.css # Profile page styling
└── styles_profile_picture.css      # Profile picture styling

resources/css/
├── app.css                         # Main Tailwind CSS
└── social.css                      # Custom social media styles
```

### JavaScript Components
```javascript
// resources/js/app.js
import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();
```

---

## UI Design System

### Color Palette
The application uses a modern dark theme with purple accents:

```css
:root {
    /* Primary Colors */
    --primary: #8b5cf6;           /* Purple */
    --primary-hover: #7c3aed;
    
    /* Background Colors */
    --bg-primary: #13111c;        /* Main background */
    --bg-secondary: #1e1b2e;      /* Card background */
    --bg-tertiary: #221f2e;       /* Input/hover background */
    
    /* Text Colors */
    --text-primary: #ffffff;
    --text-secondary: #9ca3af;    /* gray-400 */
    --text-muted: #6b7280;        /* gray-500 */
    
    /* Border Colors */
    --border: rgba(139, 92, 246, 0.2);  /* purple-500/20 */
    
    /* Accent Colors */
    --accent-pink: #ec4899;
    --accent-fuchsia: #d946ef;
}
```

### Component Styling

#### Buttons
```html
<!-- Primary Button -->
<button class="px-6 py-3 bg-gradient-to-r from-purple-500 to-fuchsia-500 
               hover:from-purple-600 hover:to-fuchsia-600 
               text-white font-semibold rounded-xl 
               shadow-lg shadow-purple-500/25 
               hover:shadow-purple-500/40 hover:scale-105 
               transition-all duration-300">
    Button Text
</button>

<!-- Secondary Button -->
<button class="px-5 py-2.5 bg-[#221f2e] text-gray-300 
               border border-purple-500/20 rounded-xl 
               hover:bg-[#2a2640] transition-all duration-300">
    Cancel
</button>

<!-- Danger Button -->
<button class="px-5 py-2.5 bg-gradient-to-r from-red-500 to-pink-500 
               text-white font-semibold rounded-xl 
               shadow-lg shadow-red-500/25 
               hover:from-red-600 hover:to-pink-600 
               transition-all duration-300">
    Delete
</button>
```

#### Cards
```html
<div class="bg-[#1e1b2e] border border-purple-500/20 rounded-xl 
            shadow-lg shadow-purple-500/5 
            hover:border-purple-500/30 hover:shadow-purple-500/10 
            transition-all duration-300">
    <!-- Card content -->
</div>
```

#### Form Inputs
```html
<input type="text" 
       class="w-full px-4 py-3 bg-[#13111c] 
              border border-purple-500/20 rounded-xl 
              text-white placeholder-gray-500 
              focus:outline-none focus:ring-2 focus:ring-purple-500/50 
              focus:border-purple-500/50 transition-all duration-300">
```

#### Profile Avatars
```html
<!-- With Image -->
<img class="w-10 h-10 rounded-full object-cover 
            ring-2 ring-purple-500 ring-offset-2 ring-offset-[#1e1b2e]">

<!-- Placeholder -->
<div class="w-10 h-10 rounded-full 
            bg-gradient-to-br from-purple-500 via-fuchsia-500 to-pink-500 
            flex items-center justify-center text-white font-bold 
            ring-2 ring-purple-500 ring-offset-2 ring-offset-[#1e1b2e]">
    A
</div>
```

### Navigation Design
The navigation features:
- Dark background (`#1e1b2e`)
- Purple gradient logo
- Icon-based navigation items
- Mobile bottom navigation bar
- Hover effects with purple glow

```html
<nav class="bg-[#1e1b2e] border-b border-purple-500/20 
            shadow-lg shadow-purple-500/5">
    <!-- Desktop navigation -->
    <div class="hidden sm:flex items-center gap-6">
        <a class="p-2 rounded-xl text-gray-400 hover:text-purple-400 
                  hover:bg-purple-500/10 transition-all duration-300">
            <!-- Icon -->
        </a>
    </div>
    
    <!-- Mobile bottom nav -->
    <div class="sm:hidden fixed bottom-0 left-0 right-0 
                bg-[#1e1b2e]/95 backdrop-blur-lg 
                border-t border-purple-500/20">
        <!-- Mobile nav items -->
    </div>
</nav>
```

### Responsive Design
- Mobile-first approach
- Bottom navigation bar on mobile
- Flexible card layouts
- Touch-friendly button sizes
- Proper spacing adjustments

### Animation & Transitions
```css
/* Standard transitions */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}

/* Hover scale effect */
.hover\:scale-105:hover {
    transform: scale(1.05);
}

/* Glow effect on hover */
.hover\:shadow-purple-500\/40:hover {
    box-shadow: 0 10px 15px -3px rgba(139, 92, 246, 0.4);
}
```

---

## Backend Controllers

### PostController
**Purpose**: Manages post creation, viewing, and file uploads

**Key Methods**:
```php
public function create()     // Show create post form
public function store()      // Process new post creation
public function show($id)    // Display individual post with likes/comments
```

**Responsibilities**:
- File upload validation
- Image storage
- Post creation
- Post retrieval with eager loading

### ProfileController
**Purpose**: Handles user profiles, following system, and feed generation

**Key Methods**:
```php
public function show($id)           // View user profile
public function toggleFollow($id)   // Follow/unfollow logic
public function feed()              // Generate personalized feed
public function search()            // User search functionality
public function uploadPhoto()       // Profile picture upload
```

**Responsibilities**:
- Profile management
- Following/unfollowing logic
- Feed generation with eager loading
- User search
- Profile photo uploads

### LikeController
**Purpose**: Handles like/unlike functionality

**Key Methods**:
```php
public function toggle(Post $post)  // Toggle like status on a post
```

**Responsibilities**:
- Toggle like state
- Return JSON for AJAX requests
- Fallback to redirect for form submissions
- Like count management

### CommentController
**Purpose**: Manages comments on posts

**Key Methods**:
```php
public function store(Request $request, Post $post)  // Add new comment
public function destroy(Comment $comment)            // Delete comment
```

**Responsibilities**:
- Comment creation with validation
- Comment deletion with authorization
- Support for both AJAX and form submissions

### Auth Controllers
**Purpose**: Handle authentication processes (provided by Laravel Breeze)

**Components**:
- `RegisteredUserController`: User registration
- `AuthenticatedSessionController`: Login/logout
- `PasswordResetLinkController`: Password reset
- `EmailVerificationController`: Email verification

---

## Security Considerations

### Input Validation
```php
// Example validation rules
$request->validate([
    'upload_file' => 'required|image|mimes:jpg,jpeg,png,webp|max:12288',
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
]);
```

### CSRF Protection
- All forms include CSRF tokens
- Laravel automatically validates CSRF tokens
- Protection against cross-site request forgery

### File Upload Security
- Restricted file types (images only)
- Size limitations
- User-specific directories
- Proper file permissions

### Database Security
- Prepared statements (Eloquent ORM)
- Foreign key constraints
- Unique constraints where needed
- Proper indexing

### Authentication Security
- Password hashing (bcrypt)
- Session management
- Rate limiting on authentication routes
- Secure password reset process

---

## Performance Optimization

### Database Optimization
```php
// Eager loading to prevent N+1 queries
$posts = Post::with(['user', 'likes', 'comments'])
            ->whereIn('author_id', $followingIds)
            ->get();

// Post detail with all relationships
$post = Post::with(['user', 'likes', 'comments.user'])
            ->findOrFail($id);

// Pagination for large datasets
$posts = Post::whereIn('author_id', $followingIds)
            ->with(['user', 'likes', 'comments'])
            ->orderBy('id', 'desc')
            ->paginate(10);
```

### Caching Strategy
- **Route Caching**: `php artisan route:cache`
- **Config Caching**: `php artisan config:cache`
- **View Caching**: `php artisan view:cache`

### Frontend Optimization
- **Asset Compilation**: Vite for modern asset bundling
- **CSS Optimization**: Tailwind CSS purging
- **Image Optimization**: Proper image sizing and formats

---

## Testing Strategy

### Test Types
```php
// Feature Tests
tests/Feature/
├── Auth/
│   ├── AuthenticationTest.php
│   ├── RegistrationTest.php
│   └── PasswordResetTest.php
├── ProfileTest.php
└── ExampleTest.php

// Unit Tests
tests/Unit/
└── ExampleTest.php
```

### Running Tests
```bash
# Run all tests
php artisan test

# Run with Pest
./vendor/bin/pest

# Run specific test file
php artisan test tests/Feature/ProfileTest.php
```

### Test Coverage Areas
- User authentication flows
- Post creation and retrieval
- Following/unfollowing functionality
- **Like/unlike functionality**
- **Comment creation and deletion**
- File upload validation
- Profile management

---

## Deployment Guide

### Production Environment Setup

#### 1. Server Requirements
- PHP 8.2 or higher
- MySQL 8.0 or higher
- Nginx or Apache web server
- Composer
- Node.js (for asset compilation)

#### 2. Environment Configuration
```bash
# Set production environment
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database configuration
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=production_db
DB_USERNAME=production_user
DB_PASSWORD=secure_password

# Cache configuration
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

#### 3. Deployment Steps
```bash
# 1. Clone repository
git clone <repository-url>
cd atestat

# 2. Install dependencies
composer install --optimize-autoloader --no-dev
npm install

# 3. Environment setup
cp .env.example .env
# Edit .env with production values
php artisan key:generate

# 4. Database setup
php artisan migrate --force

# 5. Storage setup
php artisan storage:link

# 6. Cache optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Asset compilation
npm run build

# 8. Set permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

#### 4. Web Server Configuration

**Nginx Configuration**:
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/html/atestat/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

#### 5. SSL Configuration
```bash
# Using Let's Encrypt
sudo certbot --nginx -d yourdomain.com
```

#### 6. Process Management
```bash
# Using supervisor for queue workers
sudo apt install supervisor

# Create supervisor config
sudo nano /etc/supervisor/conf.d/laravel-worker.conf

[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/atestat/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/html/atestat/storage/logs/worker.log
```

#### 7. Monitoring and Logs
```bash
# Log rotation
sudo nano /etc/logrotate.d/laravel

/var/www/html/atestat/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    notifempty
    sharedscripts
}
```

### Docker Deployment
```bash
# Using Laravel Sail in production
./vendor/bin/sail build --no-cache
./vendor/bin/sail up -d

# Or custom Docker setup
docker-compose -f docker-compose.prod.yml up -d
```

---

## Maintenance and Updates

### Regular Maintenance Tasks
```bash
# Daily tasks
php artisan queue:restart
php artisan cache:clear

# Weekly tasks
php artisan storage:link
composer dump-autoload

# Monthly tasks
php artisan migrate --force
npm run build
```

### Update Process
```bash
# 1. Backup database
mysqldump -u username -p database_name > backup.sql

# 2. Update code
git pull origin main

# 3. Update dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build

# 4. Run migrations
php artisan migrate --force

# 5. Clear caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Troubleshooting

### Common Issues

#### 1. File Upload Issues
```bash
# Check permissions
ls -la storage/
chmod -R 775 storage/

# Check disk space
df -h

# Check PHP upload limits
php -i | grep upload
```

#### 2. Database Connection Issues
```bash
# Test connection
php artisan tinker
DB::connection()->getPdo();

# Check configuration
php artisan config:show database
```

#### 3. Performance Issues
```bash
# Enable query logging
DB::enableQueryLog();
// Run your code
dd(DB::getQueryLog());

# Check slow queries
SHOW PROCESSLIST;
```

### Debug Mode
```bash
# Enable debugging (development only)
APP_DEBUG=true
LOG_LEVEL=debug

# View logs
tail -f storage/logs/laravel.log
```

---

This documentation provides a comprehensive guide to understanding, developing, and maintaining the social media platform. For specific implementation details, refer to the source code and Laravel documentation.

---

## Changelog

### Version 2.0.0 (January 22, 2026)

#### New Features

**Like System**
- Added `likes` table with user_id and post_id foreign keys
- Created `Like` model with user and post relationships
- Implemented `LikeController` with toggle functionality
- Added AJAX support for seamless like/unlike interactions
- Visual feedback with filled/unfilled heart icon
- Real-time like count updates

**Comment System**
- Added `comments` table with user_id, post_id, and body fields
- Created `Comment` model with user and post relationships
- Implemented `CommentController` with store and destroy methods
- Comment creation with validation (max 1000 characters)
- Authorization for comment deletion (owner or post author)
- Comments displayed with user info and timestamps

**UI Redesign - Dark Purple Theme**
- New dark color scheme with purple accents
- Background colors: `#13111c` (primary), `#1e1b2e` (cards), `#221f2e` (tertiary)
- Primary accent: Purple `#8b5cf6` with fuchsia gradients
- Gradient buttons with glow effects
- Modern card designs with subtle borders
- Profile avatars with gradient rings
- Responsive mobile navigation with bottom bar
- Smooth hover transitions and animations

#### Files Created
- `app/Models/Like.php`
- `app/Models/Comment.php`
- `app/Http/Controllers/LikeController.php`
- `app/Http/Controllers/CommentController.php`
- `database/migrations/2026_01_22_160557_create_likes_table.php`
- `database/migrations/2026_01_22_160603_create_comments_table.php`
- `resources/css/social.css`

#### Files Modified
- `app/Models/Post.php` - Added likes(), comments(), isLikedBy() methods
- `app/Models/User.php` - Added posts(), followers(), following() relationships
- `app/Http/Controllers/PostController.php` - Added eager loading
- `app/Http/Controllers/ProfileController.php` - Added eager loading for feed
- `routes/web.php` - Added like and comment routes
- `vite.config.js` - Added social.css to build
- `resources/views/layouts/app.blade.php` - Dark theme, AJAX like script
- `resources/views/layouts/navigation.blade.php` - Purple accent navigation
- `resources/views/posts/feed.blade.php` - Like button, comments preview
- `resources/views/posts/show.blade.php` - Full comments section
- `resources/views/posts/new.blade.php` - Purple upload styling
- `resources/views/users/profile.blade.php` - Dark theme profile
- `resources/views/users/showmyprofile.blade.php` - Dark theme profile
- `resources/views/users/search.blade.php` - Dark search box
- `resources/views/users/search-results.blade.php` - Dark user cards
- `resources/views/profile/edit.blade.php` - Dark settings cards
- `resources/views/profile/partials/*.blade.php` - Dark form styling

#### Database Changes
```sql
-- New Tables
CREATE TABLE likes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    post_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY (user_id, post_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);

CREATE TABLE comments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    post_id BIGINT UNSIGNED NOT NULL,
    body TEXT NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);
```

#### New Routes
```php
POST   /posts/{post}/like      # Toggle like on a post
POST   /posts/{post}/comments  # Add comment to a post
DELETE /comments/{comment}     # Delete a comment
```

---

### Version 1.0.0 (Initial Release)

#### Features
- User registration and authentication (Laravel Breeze)
- Profile management with photo uploads
- Image posting with validation
- Following/unfollowing system
- Personalized feed generation
- User search functionality
- Responsive design