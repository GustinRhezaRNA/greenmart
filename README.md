# Greenmart Product Catalog

A robust and dynamic Laravel 12 application for managing product catalogs. This project utilizes a clean MVC architecture enhanced with Form Requests and Service Classes, alongside a reactive frontend powered by Bootstrap 5 and jQuery.

## Features

- **Dynamic Product Input:** Users can dynamically add multiple products and multiple descriptions/images per product on a single page using a jQuery-powered interactive table.
- **Image Preview & Management:** Upload product images with instant previews. Supports image deletion with responsive UI indicators.
- **Database Transactions:** Ensures data integrity by wrapping product and multi-description insertions within robust database transactions.
- **Auto File Cleanup:** Automatic deletion of physical image files from the server when a product or description is deleted.
- **Enterprise-grade Architecture:** 
  - Controllers are kept lean.
  - Form validations are encapsulated in `ProductStoreRequest`.
  - Business logic and file handling are abstracted into `ProductService`.
  - Reusable UI elements are extracted into Blade Components (e.g., `<x-product-row>`).

## Prerequisites

Before you begin, ensure you have met the following requirements:
* **PHP:** ^8.2
* **Composer:** Latest version
* **Node.js & npm:** Latest LTS version
* **Database:** MySQL, PostgreSQL, or SQLite (configured in `.env`)

## Installation & Setup

Follow these steps to clone the repository and run the application locally.

### 1. Clone the Repository

```bash
git clone this repository
cd greenmart
```

### 2. Install Dependencies

Install the PHP dependencies using Composer:
```bash
composer install
```

Install the Node.js dependencies using npm:
```bash
npm install
```

### 3. Environment Configuration

Copy the example environment file and set up your environment variables:
```bash
cp .env.example .env
```
Generate an application encryption key:
```bash
php artisan key:generate
```

Open the `.env` file and configure your database connection settings:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### 4. Database Migration

Run the database migrations to create the necessary tables (`products` and `product_descriptions`):
```bash
php artisan migrate
```

### 5. Storage Link

Create a symbolic link to make the `storage/app/public` folder accessible from the web (required for image uploads):
```bash
php artisan storage:link
```

## Running the Application

To run the application, you need to start both the Laravel development server and the Vite frontend build tool. Open two separate terminal windows.

**Terminal 1 (Backend):**
```bash
php artisan serve
```

**Terminal 2 (Frontend):**
```bash
npm run dev
```

The application will be accessible at `http://127.0.0.1:8000`.

## Usage

1. Open your browser and navigate to `http://127.0.0.1:8000/products`.
2. Click **"Add Product"** to insert a new product entry to the table.
3. Click the green **"+"** button to add multiple descriptions and variants to the same product.
4. Click the dashed box to upload a product image. A preview will immediately appear.
5. Click **"Submit Data"** to process the request. The data will be validated, saved to the database, and the images will be stored in `/storage/app/public/products`.
6. To delete an existing product completely, click the red Trash icon on the far right of the table row. You will be prompted with a confirmation modal. Deleting a product will also permanently remove all of its associated image files from the physical storage.

## Stack & Technologies
- **Backend:** Laravel 12 (PHP)
- **Frontend Stack:** Blade Templates, Bootstrap 5.3, Vite
- **DOM Scripting:** jQuery 4.x
