<?php
session_start();
include("Connection.php");
include("Table_Creation.php");

// Redirect if user is not logged in
if (!isset($_SESSION['email']) || !isset($_SESSION['name'])) {
    header("Location: Log-in.php");
    exit();
}

// Handle delete safely
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    // 1️⃣ Delete related cart entries first
    $stmtCart = mysqli_prepare($Connection, "DELETE FROM cart WHERE PRODUCT_ID = ?");
    mysqli_stmt_bind_param($stmtCart, "i", $delete_id);
    mysqli_stmt_execute($stmtCart);
    mysqli_stmt_close($stmtCart);

    // 2️⃣ Delete the product
    $stmtProduct = mysqli_prepare($Connection, "DELETE FROM products WHERE ID = ?");
    mysqli_stmt_bind_param($stmtProduct, "i", $delete_id);
    mysqli_stmt_execute($stmtProduct);
    mysqli_stmt_close($stmtProduct);

    header("Location: ManageProducts.php");
    exit();
}

// Handle update
if (isset($_POST['update_product'])) {
    $id = intval($_POST['product_id']);
    $category = mysqli_real_escape_string($Connection, $_POST['category']);
    $name = mysqli_real_escape_string($Connection, $_POST['item_name']);
    $model = mysqli_real_escape_string($Connection, $_POST['model']);
    $price = floatval($_POST['price']);
    $desc = mysqli_real_escape_string($Connection, $_POST['description']);

    // Handle image
    $imagePath = $_POST['current_image']; // default
    if(isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0){
        $targetDir = "uploads/";
        if(!is_dir($targetDir)) { mkdir($targetDir, 0777, true); }
        $filename = time() . "_" . basename($_FILES['product_image']['name']);
        $targetFile = $targetDir . $filename;
        if(move_uploaded_file($_FILES['product_image']['tmp_name'], $targetFile)){
            $imagePath = $targetFile;
        }
    }

    $updateSQL = mysqli_prepare($Connection, "UPDATE products SET CATEGORY=?, ITEM_NAME=?, MODEL=?, PRICE=?, DESCRIPTION=?, FILE_PATH=? WHERE ID=?");
    mysqli_stmt_bind_param($updateSQL, "sssdssi", $category, $name, $model, $price, $desc, $imagePath, $id);
    mysqli_stmt_execute($updateSQL);
    mysqli_stmt_close($updateSQL);

    header("Location: ManageProducts.php");
    exit();
}

// Handle search
$searchQuery = "";
if(isset($_GET['search']) && !empty($_GET['search'])){
    $searchQuery = mysqli_real_escape_string($Connection, $_GET['search']);
    $products = mysqli_query($Connection, "SELECT * FROM products WHERE ITEM_NAME LIKE '%$searchQuery%' OR CATEGORY LIKE '%$searchQuery%' ORDER BY ID DESC");
} else {
    $products = mysqli_query($Connection, "SELECT * FROM products ORDER BY ID DESC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Products</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<h2 class="mb-4">Manage Products</h2>

<!-- Search Form -->
<form class="mb-3 d-flex" method="GET">
    <input type="search" name="search" class="form-control me-2" placeholder="Search by name or category..." value="<?php echo htmlspecialchars($searchQuery); ?>">
    <button type="submit" class="btn btn-primary">Search</button>
</form>

<table class="table table-bordered table-striped align-middle">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Category</th>
<th>Item Name</th>
<th>Model</th>
<th>Price</th>
<th>Description</th>
<th>Image</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php if(mysqli_num_rows($products) > 0){ ?>
    <?php while($row = mysqli_fetch_assoc($products)) { ?>
    <tr>
    <form method="POST" enctype="multipart/form-data">
        <td>
            <?php echo $row['ID']; ?>
            <input type="hidden" name="product_id" value="<?php echo $row['ID']; ?>">
            <input type="hidden" name="current_image" value="<?php echo $row['FILE_PATH']; ?>">
        </td>
        <td><input type="text" name="category" value="<?php echo htmlspecialchars($row['CATEGORY']); ?>" class="form-control"></td>
        <td><input type="text" name="item_name" value="<?php echo htmlspecialchars($row['ITEM_NAME']); ?>" class="form-control"></td>
        <td><input type="text" name="model" value="<?php echo htmlspecialchars($row['MODEL']); ?>" class="form-control"></td>
        <td><input type="number" step="0.01" name="price" value="<?php echo $row['PRICE']; ?>" class="form-control"></td>
        <td><input type="text" name="description" value="<?php echo htmlspecialchars($row['DESCRIPTION']); ?>" class="form-control"></td>
        <td class="text-center">
            <img src="<?php echo $row['FILE_PATH']; ?>" width="150" class="mb-2 img-thumbnail"><br>
            <input type="file" name="product_image" class="form-control form-control-sm">
        </td>
        <td class="d-flex flex-column gap-1">
            <button type="submit" name="update_product" class="btn btn-success btn-sm">Update</button>
            <a href="ManageProducts.php?delete_id=<?php echo $row['ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </form>
    </tr>
    <?php } ?>
<?php } else { ?>
<tr><td colspan="8" class="text-center text-muted">No products found.</td></tr>
<?php } ?>
</tbody>
</table>

</body>
</html>
