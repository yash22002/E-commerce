<?php
session_start();
include("Connection.php");
include("Table_Creation.php");

if (!isset($_SESSION['email'])) {
    header("Location: Log_in.php");
    exit();
}

$UserEmail = $_SESSION['email'];

// Handle Remove Action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_product_id'])) {
    $RemoveID = intval($_POST['remove_product_id']);
    $RemoveQuery = "DELETE FROM CART WHERE USER_EMAIL = '$UserEmail' AND PRODUCT_ID = $RemoveID";
    mysqli_query($Connection, $RemoveQuery);
}

// Fetch cart items
$CartQuery = "SELECT 
    PRODUCTS.ID,
    PRODUCTS.ITEM_NAME,
    PRODUCTS.PRICE,
    PRODUCTS.FILE_PATH,
    CART.QUANTITY,
    (PRODUCTS.PRICE * CART.QUANTITY) AS SUBTOTAL
FROM CART
JOIN PRODUCTS ON CART.PRODUCT_ID = PRODUCTS.ID
WHERE CART.USER_EMAIL = '$UserEmail'";

$result = mysqli_query($Connection, $CartQuery);
$TotalAmount = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/Modes.css">
    

    <style>
        .cart-card img { object-fit: contain; height: 200px; width: 100%; }
    </style>
</head>
<body>
    <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <!-- Brand -->
    <a class="navbar-brand fw-bold text-primary" href="Home.php">
      <img src="https://cdn-icons-png.flaticon.com/512/891/891462.png" alt="logo" width="30" height="30" class="d-inline-block align-text-top me-2">
      Shopterra
    </a>

    <!-- Toggler for mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Content -->
    <div class="collapse navbar-collapse" id="mainNavbar">
      <!-- Left Links -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-4">
        <li class="nav-item"><a class="nav-link" href="Home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link active" href="#">Cart</a></li>
        <li class="nav-item"><a class="nav-link" href="Checkout.php">Checkout</a></li>
      </ul>

      <!-- User Info -->
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            👤 <?php echo htmlspecialchars($_SESSION['name']); ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><span class="dropdown-item-text fw-bold">Email: <?php echo htmlspecialchars($_SESSION['email']); ?></span></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="Home.php" method="POST">
                <button type="submit" name="log-out" class="dropdown-item text-danger">Logout</button>
              </form>
            </li>
          </ul>
        </li>
      </ul>
      <!-- Mode Toggle -->
        <button class="btn btn-outline-secondary ms-2" onclick="toggleMode()" id="modeBtn">
        🌙 Dark Mode
        </button>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4">🛒 Your Shopping Cart</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="row g-4">
            <?php while ($row = mysqli_fetch_assoc($result)):
                $TotalAmount += $row['SUBTOTAL'];
            ?>
            <div class="col-md-4" data-aos="fade-right"
     data-aos-offset="300"
     data-aos-easing="ease-in-sine">
                <div class="card cart-card h-100 shadow-sm">
                    <img src="<?php echo htmlspecialchars($row['FILE_PATH']); ?>" class="card-img-top" alt="Product Image">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['ITEM_NAME']); ?></h5>
                        <p class="card-text text-success fw-bold">₹<?php echo number_format($row['PRICE'], 2); ?></p>
                        <p class="card-text">Quantity: <?php echo $row['QUANTITY']; ?></p>
                        <p class="card-text">Subtotal: ₹<?php echo number_format($row['SUBTOTAL'], 2); ?></p>
                        <form  method="POST" class="mt-auto">
                            <input type="hidden" name="remove_product_id" value="<?php echo $row['ID']; ?>">
                            <button type="submit" class="btn btn-outline-danger w-100">Remove ❌</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <div class="text-end mt-4">
            <h4>Total: ₹<?php echo number_format($TotalAmount, 2); ?></h4>
            <a href="Checkout.php" class="btn btn-primary btn-lg">Proceed to Checkout</a>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">Your cart is empty!</div>
    <?php endif; ?>
</div>
<script src="JS/Mode.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 800, // animation duration in ms
    once: true,    // animate only once when scrolling
  });
</script>
</body>
</html>
