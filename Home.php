<?php
session_start();
include("Connection.php");
include("Table_Creation.php");

// ✅ Redirect if user is not logged in
if (!isset($_SESSION['email']) || !isset($_SESSION['name'])) {
    header("Location: Log-in.php");
    exit();
}

// ✅ Session values
$Name = $_SESSION['name'];
$Email = $_SESSION['email'];

// ✅ Set user status to 'Online' only if not already set
$Status = "Online";
$updateStatus = mysqli_prepare($Connection, "UPDATE Signup SET STATUS = ? WHERE EMAIL = ?");
mysqli_stmt_bind_param($updateStatus, "ss", $Status, $Email);
mysqli_stmt_execute($updateStatus);

// ✅ Logout logic
if (isset($_POST['log-out'])) {
    $Offline = "Offline";
    $update = mysqli_prepare($Connection, "UPDATE Signup SET STATUS = ? WHERE EMAIL = ?");
    mysqli_stmt_bind_param($update, "ss", $Offline, $Email);
    mysqli_stmt_execute($update);
    session_unset(); // Clear all session variables
    session_destroy(); // End session
    header("Location: Log-in.php");
    exit();
}


$TV_Fridge =  "SELECT * FROM PRODUCTS WHERE CATEGORY = 'TV & Fridge'";
$Result_TV = mysqli_query($Connection, $TV_Fridge);
if($Result_TV){
  // echo " values Stored";
}

$Laptops =  "SELECT * FROM PRODUCTS WHERE CATEGORY = 'Laptops'";
$Result_Laptop = mysqli_query($Connection, $Laptops);
if($Result_Laptop){
  // echo " values Stored";
}
$Electronics =  "SELECT * FROM PRODUCTS WHERE CATEGORY = 'Electronics'";
$Result_Electronics = mysqli_query($Connection, $Electronics);
if($Result_Electronics){
  // echo " values Stored";
}
$Accessories= "SELECT * FROM PRODUCTS WHERE CATEGORY = 'Accessories'";
$Result_Accessories = mysqli_query($Connection, $Accessories);
if($Result_Accessories){
  // echo "values Stored";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ShopEase - Navbar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"> <!-- For cart icon -->
  <link rel="stylesheet" href="CSS/Home.css">
  <link rel="stylesheet" href="CSS/Modes.css">

</head>
<body>

  <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <!-- Brand -->
    <a class="navbar-brand fw-bold text-primary" href="#">
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
        <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Shop</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categories</a>
          <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
            <li><a class="dropdown-item" href="#">Laptops</a></li>
            <li><a class="dropdown-item" href="#">TV & Fridge</a></li>
            <li><a class="dropdown-item" href="#">Electronics</a></li>
            <li><a class="dropdown-item" href="#">Accessories</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
      </ul>

      <!-- Search -->
      <form class="d-flex me-3" role="search">
        <input class="form-control me-2" type="search" placeholder="Search products..." aria-label="Search">
        <button class="btn btn-outline-primary" type="submit">Search</button>
      </form>
      <br>
      <!-- Cart -->
      <a href="#" class="btn btn-outline-dark me-2 position-relative">
        <i class="bi bi-cart"></i>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
      </a>
      <br>
      <!-- User Info Dropdown (static for now) -->
      <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          👤 <?php echo $Name; ?>
        </button>
        <br>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><span class="dropdown-item-text fw-bold">Name: <?php echo $Name; ?></span></li>
          <li><span class="dropdown-item-text fw-bold">Email: <?php echo $Email; ?></span></li>
          <li><span class="dropdown-item-text fw-bold">Status: <?php echo $Status; ?></span></li>
          <li><hr class="dropdown-divider"></li>
          <li>
          <br>
            <form action="" method="post" style="margin: 0;">
              <button type="submit" name="log-out" class="dropdown-item text-danger">Logout</button>
            </form>
          </li>
        </ul>
      </div>

      <!-- Mode Toggle -->
      <button class="btn btn-outline-secondary ms-2" onclick="toggleMode()" id="modeBtn">
        🌙 Dark Mode
      </button>
    </div>
  </div>
</nav>


<!-- Hero Slideshow -->
<div id="shoppingCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="https://images-eu.ssl-images-amazon.com/images/G/31/img22/WLA/2025/Uber/Unrec_GW/Updated/NewUpdate_DesktopHeroTemplate_3000x1200_ref._CB550300935_.jpg" class="d-block w-100" style= "height: 540px; object-fit: cover;" alt="Shopping 1">
    </div>
    <div class="carousel-item">
      <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30" class="d-block w-100" style="height: 540px; object-fit: cover;" alt="Shopping 2">
    </div>
    <div class="carousel-item">
      <img src="https://rukminim2.flixcart.com/fk-p-flap/1620/270/image/f9ef0cb53d251e79.jpeg?q=90" class="d-block w-100" style="height: 540px; object-fit: cover;" alt="Shopping 3">
    </div>
  </div>

  <!-- Carousel Controls -->
  <button class="carousel-control-prev" type="button" data-bs-target="#shoppingCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#shoppingCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>

  <!-- Carousel Indicators -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#shoppingCarousel" data-bs-slide-to="0" class="active"></button>
    <button type="button" data-bs-target="#shoppingCarousel" data-bs-slide-to="1"></button>
    <button type="button" data-bs-target="#shoppingCarousel" data-bs-slide-to="2"></button>
  </div>
</div>

   <div class="container mt-4">

  <!-- Laptops -->
  <h2 class="section-title">Laptops</h2>
  <div class="row g-4">
    <?php while($row = mysqli_fetch_assoc($Result_Laptop)) { ?>
    <div class="col-md-4">
      <div class="card h-100"  data-aos="zoom-in-up">
        <img src="<?php echo $row['FILE_PATH']; ?>" class="card-img-top" alt="Laptop Image" height="200">
        <div class="card-body d-flex flex-column" data-aos="zoom-in">
          <h5 class="card-title"><?php echo $row['ITEM_NAME']; ?></h5>
          <p class="card-text"><?php echo $row['DESCRIPTION']; ?></p>
          <p class="card-text fw-bold text-success">₹<?php echo $row['PRICE']; ?></p>

          <!-- Add to Cart Form -->
          <form action="Cart.php" method="POST" class="mt-auto">
            <input type="hidden" name="product_id" value="<?php echo $row['ID']; ?>">
            <input type="number" name="quantity" value="1" min="1" class="form-control mb-2" required>
            <button type="submit" class="btn btn-warning w-100">Add to Cart 🛒</button>
          </form>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</div>

      <div class="container mt-4">

    <!-- TV & Fridge -->
<h2 class="section-title">TV & Fridge</h2>
<div class="row g-4">
  <?php while($row = mysqli_fetch_assoc($Result_TV)) { ?>
  <div class="col-md-4">
    <div class="card h-100" data-aos="zoom-in-up">
      <img src="<?php echo $row['FILE_PATH']; ?>" class="card-img-top" alt="TV or Fridge" height="200">
      <div class="card-body d-flex flex-column" data-aos="zoom-in">
        <h5 class="card-title"><?php echo $row['ITEM_NAME']; ?></h5>
        <p class="card-text"><?php echo $row['DESCRIPTION']; ?></p>
        <p class="card-text fw-bold text-success">₹<?php echo $row['PRICE']; ?></p>

        <!-- Add to Cart Form -->
        <form action="Cart.php" method="POST" class="mt-auto">
          <input type="hidden" name="product_id" value="<?php echo $row['ID']; ?>">
          <input type="number" name="quantity" value="1" min="1" class="form-control mb-2" required>
          <button type="submit" class="btn btn-warning w-100">Add to Cart 🛒</button>
        </form>
      </div>
    </div>
  </div>
  <?php } ?>
</div>


     <!-- Electronics -->
<h2 class="section-title">Electronics</h2>
<div class="row g-4">
  <?php while($row = mysqli_fetch_assoc($Result_Electronics)) { ?>
  <div class="col-md-4">
    <div class="card h-100" data-aos="zoom-in-up">
      <img src="<?php echo $row['FILE_PATH']; ?>" class="card-img-top" alt="Electronic Item" height="200">
      <div class="card-body d-flex flex-column" data-aos="zoom-in">
        <h5 class="card-title"><?php echo $row['ITEM_NAME']; ?></h5>
        <p class="card-text"><?php echo $row['DESCRIPTION']; ?></p>
        <p class="card-text fw-bold text-success">₹<?php echo $row['PRICE']; ?></p>

        <!-- Add to Cart Form -->
        <form action="Cart.php" method="POST" class="mt-auto">
          <input type="hidden" name="product_id" value="<?php echo $row['ID']; ?>">
          <input type="number" name="quantity" value="1" min="1" class="form-control mb-2" required>
          <button type="submit" class="btn btn-warning w-100">Add to Cart 🛒</button>
        </form>
      </div>
    </div>
  </div>
  <?php } ?>
</div>

           <!-- Accessories -->
<!-- Accessories Section -->
<h2 class="section-title mb-4">Accessories</h2>
<div class="row g-4">
  <?php while($Row = mysqli_fetch_assoc($Result_Accessories)) { ?>
    <div class="col-md-4">
      <div class="card h-100 shadow-sm" data-aos="zoom-in-up">
        <img 
          src="<?php echo htmlspecialchars($Row['FILE_PATH']); ?>" 
          class="card-img-top" 
          alt="<?php echo htmlspecialchars($Row['ITEM_NAME']); ?>" 
          style="height: 200px; object-fit: cover;"
        >
        <div class="card-body d-flex flex-column" data-aos="zoom-in">
          <h5 class="card-title"><?php echo htmlspecialchars($Row['ITEM_NAME']); ?></h5>
          <p class="card-text"><?php echo htmlspecialchars($Row['DESCRIPTION']); ?></p>
          <p class="card-text fw-bold text-success">₹<?php echo number_format($Row['PRICE']); ?></p>

          <!-- Add to Cart Form -->
          <form action="Cart.php" method="POST" class="mt-auto">
            <input type="hidden" name="product_id" value="<?php echo $Row['ID']; ?>">
            <input type="number" name="quantity" value="1" min="1" class="form-control mb-2" required>
            <button type="submit" class="btn btn-warning w-100">Add to Cart 🛒</button>
          </form>
        </div>
      </div>
    </div>
  <?php } ?>
</div>
    </div>
  </div>
<script src="JS/Mode.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 800, // animation duration in ms
    once: true,    // animate only once when scrolling
  });
</script>
</body>
</html>
