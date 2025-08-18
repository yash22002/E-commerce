<?php
session_start();
include("Connection.php");
include("Table_Creation.php");

if (!isset($_SESSION['email'])) {
    header("Location: Log_in.php");
    exit();
}

$UserEmail = $_SESSION['email'];

// Fetch total amount from CART
$CartTotalQuery = "SELECT SUM(PRODUCTS.PRICE * CART.QUANTITY) AS TOTAL 
                  FROM CART 
                  JOIN PRODUCTS ON CART.PRODUCT_ID = PRODUCTS.ID 
                  WHERE CART.USER_EMAIL = '$UserEmail'";
$totalResult = mysqli_query($Connection, $CartTotalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$TotalAmount = $totalRow['TOTAL'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Choose Payment Method</title>
<link rel="stylesheet" href="CSS/Payment.css">
<script>
    function goOnline() { window.location.href = 'OnlinePayment.php'; }
    function showCOD() {
        const form = document.getElementById('codForm');
        form.classList.add('show');
        window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
    }
</script>
</head>
<body>
    <!-- Background Video -->
    <video autoplay muted loop playsinline id="bgVideo">
        <source src="shoping.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>

    <h1>Select Payment Method</h1>

    <!-- Total Amount -->
    <div style="text-align:center; font-size:24px; margin-bottom:20px;">
        Total Amount: <strong>₹<?php echo number_format($TotalAmount, 2); ?></strong>
    </div>

    <div class="grid-container">
        <button class="btn online-btn" onclick="goOnline()">Online Payment</button>
        <button class="btn cod-btn" onclick="showCOD()">Cash on Delivery (COD)</button>
    </div>

    <div id="codForm">
        <h2>Enter Your Delivery Details</h2>
        <form action="Payment_Process.php" method="post">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="tel" name="phone" placeholder="Phone Number" required>
            
            <label>Address Type:</label>
            <select name="address_type" required>
                <option value="">Select</option>
                <option value="Home">Home</option>
                <option value="Office">Office</option>
                <option value="Other">Other</option>
            </select>

            <input type="text" name="house_no" placeholder="House / Flat / Building No" required>
            <input type="text" name="landmark" placeholder="Landmark" required>
            <input type="text" name="pincode" placeholder="Pin Code" required>

            <input type="submit" value="Place Order">
        </form>
    </div>
</body>
</html>
