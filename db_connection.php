<?php

function getDbConnection() {
    //change it based on your need
    $conn = mysqli_connect('localhost', 'root', '', 'food_orders');

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}
?>