# Laravel E-commerce

This README.md provides instructions and information about the Laravel Filament project.

## Running the Project

### Prerequisites
- PHP >= 8.2
- Composer installed


## Demo

https://ecommerce.kurousagi.fun/



## Features

- Product Management
- Product Category Management
- User Management




## Installation

1. Clone the repository.
2. Navigate to the project directory.
3. Run `composer install` to install dependencies.
4. Copy the `.env.example` file to `.env` and configure your database settings.
5. Run `php artisan key:generate` to generate the application key.
6. Run `php artisan migrate` to migrate the database.
7. Run `php artisan optimize:clear` to cache the configuration.
8. Run `php artisan storage:link` to link the storage folder.
9. Run `php artisan db:seed` if you want to have a default admin account and default categories.
    
    
## Run Locally
1. Start the development server using `php artisan serve`.
2. Access the application in your browser at `http://127.0.0.1:8000`.


## Running Tests

To run tests, run the following command

```bash
  php artisan test
```
Project only has two feature test 
- ProductTest
- UserTest

## Tech Stack

**Client:** Livewire, AlpineJS, TailwindCSS

**Server:** Laravel, PHP


## Lessons Learned

What did you learn while building this project? What challenges did you face and how did you overcome them?

1. **First Time Using Filament, Livewire & Laravel 11:** Learning to work with Filament and Livewire for the first time required familiarization with their concepts. I had 3 documentations open as i try to understand the workings of it but I enjoyed the process very much.

2. **PHP 8.2 Setup and Configuration:** I had issues where it doesn't work when on my usual terminal. I was able to make the image uploads on my laragon terminal.

3. **Test Setup:** I have experience using PHPUnit but I opted for pest as it is the testing framework used by Filament, I had some hiccups making it work and making the actual test run.