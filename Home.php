<?php
session_start();
include("Connection.php");
include("Table_Creation.php");

// Redirect if user is not logged in
if (!isset($_SESSION['email']) || !isset($_SESSION['name'])) {
    header("Location: Log-in.php");
    exit();
}

$Name = $_SESSION['name'];
$Email = $_SESSION['email'];

// Set user status to 'Online'
$Status = "Online";
$updateStatus = mysqli_prepare($Connection, "UPDATE Signup SET STATUS = ? WHERE EMAIL = ?");
mysqli_stmt_bind_param($updateStatus, "ss", $Status, $Email);
mysqli_stmt_execute($updateStatus);

// Logout
if (isset($_POST['log-out'])) {
    $Offline = "Offline";
    $update = mysqli_prepare($Connection, "UPDATE Signup SET STATUS = ? WHERE EMAIL = ?");
    mysqli_stmt_bind_param($update, "ss", $Offline, $Email);
    mysqli_stmt_execute($update);
    session_unset();
    session_destroy();
    header("Location: Log-in.php");
    exit();
}

// Handle search
$searchQuery = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchQuery = mysqli_real_escape_string($Connection, $_GET['search']);
    $searchSQL = "SELECT * FROM PRODUCTS WHERE ITEM_NAME LIKE '%$searchQuery%' OR CATEGORY LIKE '%$searchQuery%'";
    $Result_Search = mysqli_query($Connection, $searchSQL);
}

// Function to render products + modal
function renderSection($title, $result) {
    if(mysqli_num_rows($result) > 0) {
        echo "<h2 class='section-title mt-5'>$title</h2><div class='row g-4'>";
        while($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4">
                <div class="card h-100" data-aos="zoom-in-up">
                    <img src="<?php echo $row['FILE_PATH']; ?>" class="card-img-top"
                         data-bs-toggle="modal" data-bs-target="#productModal<?php echo $row['ID']; ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo $row['ITEM_NAME']; ?></h5>
                        <p class="card-text fw-bold text-success">₹<?php echo $row['PRICE']; ?></p>
                        <button class="btn btn-primary w-100 mb-2"
                                data-bs-toggle="modal" data-bs-target="#productModal<?php echo $row['ID']; ?>">
                            View Details
                        </button>
                        <form action="Cart.php" method="POST" class="mt-auto">
                            <input type="hidden" name="product_id" value="<?php echo $row['ID']; ?>">
                            <input type="number" name="quantity" value="1" min="1" class="form-control mb-2" required>
                            <button type="submit" class="btn btn-warning w-100">Add to Cart 🛒</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="productModal<?php echo $row['ID']; ?>" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><?php echo $row['ITEM_NAME']; ?></h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body row">
                            <div class="col-md-6">
                                <img src="<?php echo $row['FILE_PATH']; ?>" class="img-fluid rounded">
                            </div>
                            <div class="col-md-6">
                                <h4 class="text-success">₹<?php echo $row['PRICE']; ?></h4>
                                <p><?php echo $row['DESCRIPTION']; ?></p>
                                <p class="text-danger"><strong>Discount:</strong> 10% OFF</p>
                                <form action="Cart.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $row['ID']; ?>">
                                    <label class="form-label mt-2">Quantity:</label>
                                    <input type="number" name="quantity" value="1" min="1" class="form-control mb-2" required>
                                    <button type="submit" class="btn btn-success w-100 mt-2">Buy Now 🚀</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
        echo "</div>";
    } else {
        echo "<h4 class='mt-4 text-center text-muted'>No products found.</h4>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ShopEase - Home</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<link rel="stylesheet" href="CSS/Home.css">
<link rel="stylesheet" href="CSS/Modes.css">
<style>
.card-img-top{height:200px;object-fit:cover;cursor:pointer;}
@media(max-width:768px){.card-img-top{height:150px;}}
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold text-primary" href="#"><img src="https://cdn-icons-png.flaticon.com/512/891/891462.png" width="30" class="me-2">Shopterra</a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav me-auto ms-4">
        <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Shop</a></li>
      </ul>

      <!-- Search -->
      <form class="d-flex me-3" method="GET">
        <input class="form-control me-2" type="search" name="search" placeholder="Search products..." value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button class="btn btn-outline-primary" type="submit">Search</button>
      </form>

      <!-- Cart -->
      <a href="Cart.php" class="btn btn-outline-dark me-2 position-relative">
        <i class="bi bi-cart"></i>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
      </a>

      <!-- Profile Dropdown -->
      <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
          <i class="bi bi-person-circle me-2"></i> <?php echo $Name; ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow p-3 rounded-3" style="min-width:260px;">
          <li class="text-center mb-2">
            <i class="bi bi-person-circle text-primary" style="font-size:2.5rem;"></i>
            <h6 class="mt-2 mb-0 fw-bold"><?php echo $Name; ?></h6>
            <small class="text-muted"><?php echo $Email; ?></small>
            <div class="badge bg-<?php echo ($Status=="Online"?"success":"secondary"); ?> mt-2"><?php echo $Status; ?></div>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item d-flex align-items-center" href="#"><i class="bi bi-gear me-2"></i>Account Settings</a></li>
          <li><a class="dropdown-item d-flex align-items-center" href="Add_To_Cart.php"><i class="bi bi-cart4 me-2"></i>My Cart</a></li>
          <li>
            <form method="post" class="m-0">
              <button type="submit" name="log-out" class="dropdown-item d-flex align-items-center text-danger">
                <i class="bi bi-box-arrow-right me-2"></i>Logout
              </button>
            </form>
          </li>
        </ul>
      </div>

      <button class="btn btn-outline-secondary ms-2" onclick="toggleMode()" id="modeBtn">🌙 Dark Mode</button>
    </div>
  </div>
</nav>

<div class="container mt-4">

<?php
if(!empty($searchQuery)){
    renderSection("Search Results for '$searchQuery'", $Result_Search);
} else {
    // Fetch all unique categories dynamically
    $categoryQuery = mysqli_query($Connection, "SELECT DISTINCT CATEGORY FROM PRODUCTS");
    while($cat = mysqli_fetch_assoc($categoryQuery)){
        $catName = $cat['CATEGORY'];
        $catResult = mysqli_query($Connection, "SELECT * FROM PRODUCTS WHERE CATEGORY='$catName'");
        renderSection($catName, $catResult);
    }
}
?>
</div>
<!-- Promotions Section -->
<div class="container mt-5">
    <h2 class="text-center mb-4" data-aos="fade-up">🔥 Hot Promotions & Deals 🔥</h2>
    
    <!-- Video Promo -->
    <div class="row justify-content-center mb-5" data-aos="zoom-in">
        <div class="col-lg-8 col-md-10">
            <div class="ratio ratio-16x9 shadow rounded-3 overflow-hidden">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/R3GfuzLMPkA?si=Z5D6aROWvZ2N1Wtc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <!-- Advertisement Banners -->
    <div class="row g-4">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card shadow-sm rounded-3 overflow-hidden">
                <img src="assets/3-11-e1672903814934.jpg" class="card-img-top" alt="Ad 1">
                <div class="card-body text-center">
                    <h5 class="card-title">Up to 20% Off Laptops!</h5>
                    <p class="card-text text-muted">Limited time offer on top brands.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card shadow-sm rounded-3 overflow-hidden">
                <img src="assets/pexels-xtrovarts-16812192.jpg" class="card-img-top" alt="Ad 2">
                <div class="card-body text-center">
                    <h5 class="card-title">Smartphones Mega Sale!</h5>
                    <p class="card-text text-muted">Grab the latest phones at amazing prices.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="card shadow-sm rounded-3 overflow-hidden">
                <img src="assets/3-20-e1662987253972.jpg" class="card-img-top" alt="Ad 3">
                <div class="card-body text-center">
                    <h5 class="card-title">Laptops</h5>
                    <p class="card-text text-muted">Mouse, Keyboard & More!</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="JS/Mode.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({duration:800, once:true});</script>
</body>
</html>
