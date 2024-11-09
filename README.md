<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>
---

## About This Project

This project is a **full-stack web application** built with **Laravel**, **Inertia.js**, **React**, and **Vite**. It combines Laravel's powerful backend features with the smooth interactivity of React and the speed of Vite for modern, high-performance development.

It provides a seamless integration between **Laravel** for the backend API and **React** on the frontend, using **Inertia.js** to bridge the two. This setup is ideal for developers looking to build modern applications with a clean separation of concerns and optimal performance.

### Features

-   **Backend**: Built with Laravel, offering an expressive, elegant syntax.
-   **Frontend**: React components with real-time updates powered by Inertia.js.
-   **Development**: Fast development environment with **Vite**.
-   **Database**: Supports both traditional SQL and **MongoDB**.
-   **Modern Tools**: Includes TailwindCSS for styling, React for UI components, and Vite for fast bundling.

## Installation

To get started with this project, follow the instructions below:

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/yourproject.git
cd yourproject
```

### 2. Install PHP Dependencies

This project requires PHP 8.2+ and Composer to manage backend dependencies.

```bash
 composer install
 composer update
```

### 3. Install Node Dependencies

The frontend is managed using Vite and React. Run the following command to install the Node dependencies:

```bash
 npm install
```

## Environment Setup

### 1. Create .env File

Copy the .env.example file to .env:

```bash
cp .env.example .env
```

### 2. MongoDB Setup (Optional)

This project supports MongoDB through the mongodb/laravel-mongodb package. Configure your MongoDB connection in .env:

```bash
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=your_database_name
```

## Development

To start the development environment, run the following command:

```bash
npm run dev
```

This will start both the backend development

```bash
php artisan serve
```

This will start both the backend development
