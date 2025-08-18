<?php
include("Connection.php");

// 1. Create Database if it doesn't exist
$Database = "CREATE DATABASE IF NOT EXISTS ShopEase";
if (mysqli_query($Connection, $Database)) {
    $UseDB = "USE ShopEase";
    if (!mysqli_query($Connection, $UseDB)) {
        die("Error selecting database: " . mysqli_error($Connection));
    }
} else {
    die("Error creating database: " . mysqli_error($Connection));
}

// 2. Signup Table
$CreateSignupTable = "CREATE TABLE IF NOT EXISTS Signup (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    NAME VARCHAR(100) NOT NULL,
    EMAIL VARCHAR(100) NOT NULL UNIQUE,
    CONTACT VARCHAR(15) NOT NULL,
    PASSWORD VARCHAR(255) NOT NULL,
    C_PASSWORD VARCHAR(255) NOT NULL,
    STATUS VARCHAR(20) DEFAULT 'INACTIVE'
)";
if (!mysqli_query($Connection, $CreateSignupTable)) {
    die("Error creating Signup table: " . mysqli_error($Connection));
}

// 3. Categories Table (NEW)
$CreateCategoriesTable = "CREATE TABLE IF NOT EXISTS Categories (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    CATEGORY_NAME VARCHAR(100) UNIQUE NOT NULL
)";
if (!mysqli_query($Connection, $CreateCategoriesTable)) {
    die("Error creating Categories table: " . mysqli_error($Connection));
}

// 4. PRODUCTS Table (linked to Categories )
$CreateProductsTable = "CREATE TABLE IF NOT EXISTS PRODUCTS (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    CATEGORY_ID INT NOT NULL,
    ITEM_NAME VARCHAR(255),
    MODEL VARCHAR(100),
    PRICE DECIMAL(10, 2),
    DESCRIPTION TEXT,
    FILE_PATH VARCHAR(255),
    UPLOADED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (CATEGORY_ID) REFERENCES Categories(ID) ON DELETE CASCADE
)";
if (!mysqli_query($Connection, $CreateProductsTable)) {
    die("Error creating PRODUCTS table: " . mysqli_error($Connection));
}

// 5. CART Table
$CreateCartTable = "CREATE TABLE IF NOT EXISTS CART (
    CART_ID INT AUTO_INCREMENT PRIMARY KEY,
    USER_EMAIL VARCHAR(100) NOT NULL,
    PRODUCT_ID INT NOT NULL,
    QUANTITY INT DEFAULT 1,
    FOREIGN KEY (PRODUCT_ID) REFERENCES PRODUCTS(ID) ON DELETE CASCADE
)";
if (!mysqli_query($Connection, $CreateCartTable)) {
    die("Error creating CART table: " . mysqli_error($Connection));
}

// 6. ORDERS Table
$CreateOrdersTable = "CREATE TABLE IF NOT EXISTS ORDERS (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    USER_EMAIL VARCHAR(255),
    FIRST_NAME VARCHAR(100),
    LAST_NAME VARCHAR(100),
    ADDRESS TEXT,
    LANDMARK VARCHAR(255),
    PINCODE VARCHAR(10),
    PICKUP_DATE DATE,
    ORDER_DATE TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if (!mysqli_query($Connection, $CreateOrdersTable)) {
    die("Error creating ORDERS table: " . mysqli_error($Connection));
}
// Table creation query stored in variable
$codTable = "CREATE TABLE IF NOT EXISTS `cod_orders` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(15) NOT NULL,
    `address_type` VARCHAR(20) NOT NULL,
    `house_no` VARCHAR(50) NOT NULL,
    `landmark` VARCHAR(100) NOT NULL,
    `pincode` VARCHAR(10) NOT NULL,
    `order_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

// Execute query and check
if (mysqli_query($Connection, $codTable)) {
    // echo "Table 'cod_orders' is ready!";
} else {
    echo "Error creating table: " . mysqli_error($Connection);
}
// echo "All tables are created or already exist.";
?>
