# Food Order System

A comprehensive food ordering system with an admin panel for managing food items, categories, and orders.

## Project Structure

food-order/
  admin/
    category/
      index.php
      add-category.php
      update-category.php
      delete-category.php
    food/
      index.php
      add-food.php
      update-food.php
      delete-food.php
    order/
      index.php
      update-order.php
    user/
      index.php
      add-admin.php
      update-admin.php
      delete-admin.php
    components/
      menu.php
      footer.php
    css/
      admin.css
  images/
    category/
    food/
  config.php


## Features

### Admin Panel
- User Management (Add/Update/Delete Admins)
- Category Management (Add/Update/Delete Food Categories)
- Food Item Management (Add/Update/Delete Food Items)
- Order Management (View Orders and Update Status)
- Image Upload Functionality for Food Items and Categories

### Styling
- Modern and responsive design
- Clean user interface with cards and tables
- Consistent styling across all pages
- Mobile-friendly layout

## Setup Instructions


1. Import the database schema:


- Create a database named `food_order`
- Import the provided SQL files for tables:

- admin
- food_category
- food
- orders
- order_items

-MAKE SURE THAT YOUR DB CONNECTIONS ARE DONE CORRECTLY

2. Set up the image directories:


- Ensure the `images/category` and `images/food` directories exist and have write permissions


## Database Schema

### Admin Table

```sql
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    user_name VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Food Categories Table

```sql
CREATE TABLE food_category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    image_path VARCHAR(255),
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Food Items Table

```sql
CREATE TABLE food (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image_path VARCHAR(255),
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES food_category(id) ON DELETE CASCADE
);
```

### Orders Table

```sql
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20),
    total_amount DECIMAL(10, 2) NOT NULL,
    status ENUM('Pending', 'Processing', 'Delivered', 'Cancelled') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Order Items Table

```sql
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    food_id INT NOT NULL,
    quantity INT NOT NULL,
    item_price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (food_id) REFERENCES food(id) ON DELETE RESTRICT
);
```

## Run the Project

Run the command below on root directory
```cmd
 php -S localhost:8000
```

## Technologies Used

- PHP
- MySQL
- HTML/CSS
- JavaScript


## Security Features

- Password Hashing for Admin Accounts
- Input Validation and Sanitization
- Prepared Statements for Database Queries
- Session Management
- XSS Protection


## Author

Hishaam Rafeeu 

## License

This project is licensed under the MIT License