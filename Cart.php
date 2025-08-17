<?php
session_start();
include("Connection.php");
include("Table_Creation.php");

if (!isset($_SESSION['email'])) {
    header("Location: Log_in.php");
    exit();
}

$Email = $_SESSION['email'];
$ProductID = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$Quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

if ($ProductID > 0 && $Quantity > 0) {

    // Escape to prevent injection
    $SafeEmail = mysqli_real_escape_string($Connection, $Email);

    // Check if item already in cart
    $CheckQuery = "SELECT * FROM CART WHERE USER_EMAIL = '$SafeEmail' AND PRODUCT_ID = $ProductID";
    $CheckResult = mysqli_query($Connection, $CheckQuery);

    if (mysqli_num_rows($CheckResult) > 0) {
        // Update quantity
        $UpdateQuery = "UPDATE CART 
                        SET QUANTITY = QUANTITY + $Quantity 
                        WHERE USER_EMAIL = '$SafeEmail' AND PRODUCT_ID = $ProductID";
        mysqli_query($Connection, $UpdateQuery);
    } else {
        // Insert new item
        $InsertQuery = "INSERT INTO CART (USER_EMAIL, PRODUCT_ID, QUANTITY) 
                        VALUES ('$SafeEmail', $ProductID, $Quantity)";
        mysqli_query($Connection, $InsertQuery);
    }

    // Only one redirect — to cart page
    header("Location: Add_To_Cart.php"); // 👈 Change this to your cart page
    exit();

} else {
    echo "Invalid product or quantity.";
}
?>
