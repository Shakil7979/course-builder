# Course Builder - Course Management System

A comprehensive Course Builder System built with Laravel 12 for creating and managing courses with dynamic modules and content.

## 🚀 Features

- **Course Builder**: Create, view courses with dynamic structure
- **Module Management**: Add unlimited modules to each course
- **Content Management**: Support for text, video, and image content types
- **Real-time Interface**: Dynamic form handling with jQuery and AJAX
- **Responsive Design**: Mobile-friendly design interface
- **Validation**: Comprehensive client-side and server-side form validation

## 🛠️ Technology Stack

### Backend
- **Laravel 12** - PHP Framework
- **MySQL** - Database
- **Eloquent ORM** - Database operations

### Frontend
- **HTML5** - Markup
- **CSS3** - Styling with custom stylesheets 
- **JavaScript** - Client-side functionality
- **jQuery** - DOM manipulation and event handling
- **AJAX** - Asynchronous form submissions

### Additional Tools
- **Font Awesome** - Icons
- **Laravel Blade** - Templating engine

## 📋 Prerequisites

Before installation, ensure you have:
- PHP 8.1 or higher
- Composer
- MySQL Database 

## 🔧 Installation 

## 1. Clone the repository
```php
git clone https://github.com/Shakil7979/course-builder.git
cd course-builder
```


## 2. Install PHP dependencies
```php
composer install
```

4. Setup environment
```php
cp .env.example .env
php artisan key:generate
```

6. Configure database
```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=course_builder
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run migrations
```php
php artisan migrate
```

8. Start development server
```php
php artisan serve
```

9. Access application
```php
http://localhost:8000
```
 

