<?php
session_start();
include("Connection.php"); // Your DB connection file
include("Table_Creation.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = mysqli_real_escape_string($Connection, $_POST['name']);
    $email = mysqli_real_escape_string($Connection, $_POST['email']);
    $phone = mysqli_real_escape_string($Connection, $_POST['phone']);
    $address_type = mysqli_real_escape_string($Connection, $_POST['address_type']);
    $house_no = mysqli_real_escape_string($Connection, $_POST['house_no']);
    $landmark = mysqli_real_escape_string($Connection, $_POST['landmark']);
    $pincode = mysqli_real_escape_string($Connection, $_POST['pincode']);

    // Insert data into cod_orders table
    $insert = "INSERT INTO cod_orders 
        (name, email, phone, address_type, house_no, landmark, pincode) 
        VALUES ('$name', '$email', '$phone', '$address_type', '$house_no', '$landmark', '$pincode')";

    if (mysqli_query($Connection, $insert)) {
        echo "<script>alert('Your COD order has been placed successfully!');</script>";
        echo "<script>window.location.href='#';</script>";
    } else {
        echo "<script>alert('Error placing order. Please try again.');</script>";
        echo "<script>window.location.href='PaymentOption.php';</script>";
    }
}
?>
