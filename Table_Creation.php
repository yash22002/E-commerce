<?php
include("Connection.php");
$Database="CREATE DATABASE IF NOT EXISTS ShopEase";

if(mysqli_query($Connection,$Database)){
    $UseDB="USE ShopEase";
    if(mysqli_query($Connection,$UseDB)){
        // echo "Create DataBase ShopEase";
    }else{
        die($Connection);
    }

}else{
    die($Connection);
}

$Craete_Table="CREATE TABLE IF NOT EXISTS Signup (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    NAME VARCHAR(100) NOT NULL,
    EMAIL VARCHAR(100) NOT NULL UNIQUE,
    CONTACT VARCHAR(15),
    PASSWORD VARCHAR(255) NOT NULL,
    C_PASSWORD VARCHAR(255) NOT NULL,
    STATUS VARCHAR(20) DEFAULT 'INACTIVE'
);
";
if(mysqli_query($Connection,$Craete_Table)){
    // echo "Crate Table";
}else{
    die($Connection);
}


$Server = "CREATE TABLE IF NOT EXISTS PRODUCTS (
  ID INT AUTO_INCREMENT PRIMARY KEY,
  CATEGORY VARCHAR(100),
  ITEM_NAME VARCHAR(255),
  MODEL VARCHAR(100),
  PRICE DECIMAL(10, 2),
  DESCRIPTION TEXT,
  FILE_PATH VARCHAR(255),
  UPLOADED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($Connection, $Server)) {
    // echo "PRODUCTS Table Is Created...";
} else {
    echo "Error: " . mysqli_error($Connection);
}


$CART_TABLE = "CREATE TABLE IF NOT EXISTS CART (
    CART_ID INT AUTO_INCREMENT PRIMARY KEY,
    USER_EMAIL VARCHAR(100) NOT NULL,
    PRODUCT_ID INT NOT NULL,
    QUANTITY INT DEFAULT 1,
    FOREIGN KEY (PRODUCT_ID) REFERENCES PRODUCTS(ID)
)";
if (mysqli_query($Connection, $CART_TABLE)) {
    // echo "CART table created successfully";
} else {
    echo "Error creating CART";
}

?>