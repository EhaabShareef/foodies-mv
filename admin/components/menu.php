<?php
include('../db_connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food - Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
</head>
<body>
    <header class="nav">
        <div class="container">
            <nav>
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="/admin/index.php" class="nav__link">Home</a>
                    </li>
                    <li class="nav__item">
                        <a href="/admin/user/index.php" class="nav__link">Admin Manager</a>
                    </li>
                    <li class="nav__item">
                        <a href="/admin/category/index.php" class="nav__link">Category</a>
                    </li>
                    <li class="nav__item">
                        <a href="/admin/food/index.php" class="nav__link">Food</a>
                    </li>
                    <li class="nav__item">
                        <a href="/admin/order/index.php" class="nav__link">Order</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

<!-- Main content will start after thins -->