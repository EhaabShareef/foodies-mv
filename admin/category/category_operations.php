<?php
// food_category_operations.php

// Add Food Category Function
function addFoodCategory($name, $description, $image_path, $is_active) {
    $conn = getDbConnection();
    
    $sql = "INSERT INTO food_category (name, description, image_path, is_active) 
            VALUES ('$name', '$description', '$image_path', '$is_active')";

    if (mysqli_query($conn, $sql)) {
        return true; 
    } else {
        return "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}

// Delete Food Category Function
function deleteFoodCategory($category_id) {
    $conn = getDbConnection();
    
    $sql = "DELETE FROM food_category WHERE id = '$category_id'";

    if (mysqli_query($conn, $sql)) {
        return true; 
    } else {
        return "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}

// Update Food Category Function
function updateFoodCategory($category_id, $name, $description, $image_path, $is_active) {
    $conn = getDbConnection();

    $sql = "UPDATE food_category 
            SET name = '$name', description = '$description', image_path = '$image_path', is_active = '$is_active' 
            WHERE id = '$category_id'";

    if (mysqli_query($conn, $sql)) {
        return true; 
    } else {
        return "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}

// Fetch All Food Categories Function
function fetchAllFoodCategories() {
    $conn = getDbConnection();
    
    $sql = "SELECT * FROM food_category";
    $result = mysqli_query($conn, $sql);

    $categories = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }
    } else {
        return "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
    return $categories;
}

// Fetch Single Food Category by ID Function
function fetchFoodCategoryById($category_id) {
    $conn = getDbConnection();

    $sql = "SELECT * FROM food_category WHERE id = '$category_id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        return mysqli_fetch_assoc($result);
    } else {
        return "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
