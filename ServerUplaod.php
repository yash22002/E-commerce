<?php

include("Connection.php");
include("Table_Creation.php");

if(isset($_FILES['file'])){

    echo "<pre>";
    print_r($_FILES['file']);
    echo "<pre>";


    $Category    = $_POST['category'];
    $item_name   = $_POST['item_name'];
    $model       = $_POST['model'];
    $price       = $_POST['price'];
    $description = $_POST['description'];

    $fileName = $_FILES['file']['name'];
    $TempName = $_FILES['file']['tmp_name'];
    $fileDestination = '';


    if($Category == "Laptops"){
        $fileDestination = 'Items/Laptops/' . basename($fileName);
        if(move_uploaded_file($TempName,$fileDestination)){
            $query = "INSERT INTO PRODUCTS (CATEGORY, ITEM_NAME, MODEL, PRICE, DESCRIPTION, FILE_PATH)
          VALUES ('$Category', '$item_name', '$model', '$price', '$description', '$fileDestination')";

        }
        if(mysqli_query($Connection,$query)){
           header("location:Server_Upload.php");
            // echo "File Uploaded";
        }else{
            echo mysqli_error($Connection);
        }

    }elseif($Category == "TV & Fridge"){
        $fileDestination='Items/Tv & Fredges/' . basename($fileName);
        if(move_uploaded_file($TempName,$fileDestination)){
            $query = "INSERT INTO PRODUCTS (CATEGORY, ITEM_NAME, MODEL, PRICE, DESCRIPTION, FILE_PATH)
          VALUES ('$Category', '$item_name', '$model', '$price', '$description', '$fileDestination')";

        }
        if(mysqli_query($Connection,$query)){
            header("location:Server_Upload.php");
            // echo "File Uploaded";

        }else{
            echo mysqli_error($Connection);
        }

    }elseif($Category == "Electronics"){
        $fileDestination='Items/Electronics/' . basename($fileName);
        if(move_uploaded_file($TempName,$fileDestination)){
            $query = "INSERT INTO PRODUCTS (CATEGORY, ITEM_NAME, MODEL, PRICE, DESCRIPTION, FILE_PATH)
          VALUES ('$Category', '$item_name', '$model', '$price', '$description', '$fileDestination')";
        }
        if(mysqli_query($Connection,$query)){
            header("location:Server_Upload.php");
            // echo "File Uploaded";
        }else{
            echo mysqli_error($Connection);
        }

    }elseif($Category == "Accessories"){
        $fileDestination='Items/Accessories/' . basename($fileName);
        if(move_uploaded_file($TempName,$fileDestination)){
            $query = "INSERT INTO PRODUCTS (CATEGORY, ITEM_NAME, MODEL, PRICE, DESCRIPTION, FILE_PATH)
          VALUES ('$Category', '$item_name', '$model', '$price', '$description', '$fileDestination')";
        }
        if(mysqli_query($Connection,$query)){
            header("location:Server_Upload.php");
            // echo "File Uploaded";
        }else{
            echo mysqli_error($Connection);
        }

    }else{

        echo "Default Choice";

    }    

}
?>