<?php
include("Connection.php");
include("Table_Creation.php");

if (isset($_POST['submit']) && isset($_FILES['file'])) {

    $Category    = $_POST['category'];
    $item_name   = $_POST['item_name'];
    $model       = $_POST['model'];
    $price       = $_POST['price'];
    $description = $_POST['description'];

    // Agar user "new" select kare to naya category lo
    if ($Category === "new" && !empty($_POST['new_category'])) {
        $Category = trim($_POST['new_category']);
    }

    // File handling
    $fileName = $_FILES['file']['name'];
    $TempName = $_FILES['file']['tmp_name'];

    // Folder path set
    $folderPath = "Items/" . $Category . "/";

    // Agar folder exist nahi karta to create kar do
    if (!is_dir($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    $fileDestination = $folderPath . basename($fileName);

    if (move_uploaded_file($TempName, $fileDestination)) {
        $query = "INSERT INTO PRODUCTS (CATEGORY, ITEM_NAME, MODEL, PRICE, DESCRIPTION, FILE_PATH) 
                  VALUES ('$Category', '$item_name', '$model', '$price', '$description', '$fileDestination')";

        if (mysqli_query($Connection, $query)) {
            header("Location: Server_Upload.php");
            exit;
        } else {
            echo "❌ Database Error: " . mysqli_error($Connection);
        }
    } else {
        echo "❌ File Upload Failed!";
    }
}
?>
