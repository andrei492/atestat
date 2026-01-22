# Social Media Platform - Laravel Project

A modern social media web application built with Laravel 11, featuring user authentication, image posting, following system, and real-time feed updates.

## 🚀 Features

### Core Functionality
- **User Authentication**: Complete registration, login, and profile management system
- **Image Posting**: Users can upload and share images with file validation
- **Following System**: Follow/unfollow other users to curate your feed
- **Personal Feed**: View posts from users you follow in chronological order
- **Profile Management**: Upload profile pictures and view user profiles
- **User Search**: Search for other users by name
- **Responsive Design**: Mobile-friendly interface with Tailwind CSS

### Technical Features
- **File Upload**: Secure image upload with validation (max 12MB)
- **Database Relationships**: Proper foreign key relationships between users, posts, and followers
- **Pagination**: Efficient pagination for feed and posts
- **Profile Photos**: User profile picture upload and display
- **Dark Mode Support**: Built-in dark mode compatibility

## 🛠️ Technology Stack

- **Backend**: Laravel 11 (PHP 8.2+)
- **Frontend**: Blade Templates, Alpine.js, Tailwind CSS
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **Testing**: Pest PHP
- **Build Tool**: Vite
- **Containerization**: Docker (Laravel Sail)

## 📋 Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js and npm
- MySQL database

## 🔧 Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd atestat
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   # Configure MySQL database in .env file
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   
   # Run migrations
   php artisan migrate
   ```

6. **Storage setup**
   ```bash
   php artisan storage:link
   ```

7. **Build frontend assets**
   ```bash
   npm run dev
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

## 🐳 Docker Installation (Laravel Sail)

1. **Start with Sail**
   ```bash
   ./vendor/bin/sail up -d
   ```

2. **Run migrations**
   ```bash
   ./vendor/bin/sail artisan migrate
   ```

3. **Build frontend assets**
   ```bash
   ./vendor/bin/sail npm run dev
   ```

The application will be available at `http://localhost:8080`

## 📁 Project Structure

```
atestat/
├── app/
│   ├── Http/Controllers/
│   │   ├── PostController.php      # Post management
│   │   └── ProfileController.php   # User profiles and following
│   └── Models/
│       ├── User.php               # User model
│       ├── Post.php               # Post model
│       └── Follower.php           # Following relationships
├── database/
│   └── migrations/                # Database structure
├── resources/
│   ├── views/
│   │   ├── posts/                 # Post-related views
│   │   └── users/                 # User profile views
│   └── css/                       # Custom stylesheets
├── routes/
│   └── web.php                    # Application routes
└── public/
    └── css/                       # Static CSS files
```

## 🗄️ Database Schema

### Users Table
- `id` - Primary key
- `name` - User's display name
- `email` - User's email (unique)
- `password` - Hashed password
- `profile_photo` - Profile picture path
- `created_at`, `updated_at` - Timestamps

### Posts Table
- `id` - Primary key
- `author_id` - Foreign key to users table
- `image_path` - Path to uploaded image
- `created_at`, `updated_at` - Timestamps

### Followers Table
- `id` - Primary key
- `follower_id` - User who follows (Foreign key to users)
- `following_id` - User being followed (Foreign key to users)
- `created_at`, `updated_at` - Timestamps
- Unique constraint on `(follower_id, following_id)`

## 🔐 Authentication

The application uses **Laravel Breeze** for authentication, providing:
- User registration and login
- Password reset functionality
- Email verification
- Session management

## 📱 Key Routes

### Public Routes
- `/` - Welcome page with login/register options
- `/login` - User login
- `/register` - User registration

### Authenticated Routes
- `/dashboard` - User dashboard
- `/feed` - Social media feed
- `/posts/create` - Create new post
- `/posts/{id}` - View individual post
- `/profile/{id}` - View user profile
- `/public_profile` - View own profile
- `/search` - Search for users
- `/profile/photo` - Upload profile picture

## 🖼️ File Upload

The application supports image uploads with:
- **Validation**: Only image files (jpg, jpeg, png, webp)
- **Size limit**: Maximum 12MB per image
- **Storage**: Files stored in `storage/app/public/uploads/{user_id}/`
- **Security**: Proper file validation and sanitization

## 🎨 Styling

The application uses:
- **Tailwind CSS**: For responsive utility-first styling
- **Custom CSS**: Additional styling for posts and profiles
- **Alpine.js**: For interactive components
- **Dark mode**: Built-in support for dark/light themes

## 🧪 Testing

Run the test suite:
```bash
php artisan test
```

Or using Pest:
```bash
./vendor/bin/pest
```

## 🚀 Deployment

### Environment Configuration
Ensure these environment variables are set:
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=your-domain.com`
- Database connection settings
- File storage configuration

### Production Steps
1. Run `composer install --optimize-autoloader --no-dev`
2. Run `npm run build`
3. Run `php artisan config:cache`
4. Run `php artisan route:cache`
5. Run `php artisan view:cache`
6. Set up proper file permissions
7. Configure web server

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📞 Support

For issues and questions, please use the GitHub issues page or contact the development team.

---

**Note**: This is a student project (atestat) demonstrating social media functionality with Laravel. It includes core features like user authentication, image posting, following system, and feed generation.
