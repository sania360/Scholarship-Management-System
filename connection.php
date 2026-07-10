<?php
$conn = mysqli_connect("localhost", "root", "", "scholarship_system");

if (!$conn) {
    die(" Database connection failed: " . mysqli_connect_error());
} else {
    echo " Database connected successfully";
}
?>

