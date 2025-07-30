<?php
session_start();
include("Connection.php"); // ✅ Database connection
include("Table_Creation.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['sign-up'])) {
    // Form data
    $Name = trim($_POST['name']);
    $Email = trim($_POST['email']);
    $Contact = trim($_POST['contact']);
    $Password = $_POST['password'];
    $CPassword = $_POST['c-password'];

    // ✅ 1. Password match check
    if ($Password !== $CPassword) {
        echo "<script>alert('Passwords do not match'); window.location='Sign_Up.php';</script>";
        exit();
    }

    // ✅ 2. Validate contact (digits only)
    if (!preg_match('/^\d{10,15}$/', $Contact)) {
        echo "<script>alert('Enter a valid contact number (10-15 digits only)'); window.location='Sign_Up.php';</script>";
        exit();
    }

    // ✅ 3. Check if email already exists
    $checkStmt = mysqli_prepare($Connection, "SELECT EMAIL FROM Signup WHERE EMAIL = ?");
    mysqli_stmt_bind_param($checkStmt, "s", $Email);
    mysqli_stmt_execute($checkStmt);
    mysqli_stmt_store_result($checkStmt);

    if (mysqli_stmt_num_rows($checkStmt) > 0) {
        echo "<script>alert('Account already exists with this email!'); window.location='Sign_Up.php';</script>";
        exit();
    }

    // ✅ 4. Hash passwords
    $HashedPassword = password_hash($Password, PASSWORD_DEFAULT);
    $HashedCPassword = password_hash($CPassword, PASSWORD_DEFAULT); // Even if not useful, to satisfy NOT NULL

    $Status = "Online"; // or 'Inactive'

    // ✅ 5. Insert with C_PASSWORD
    $insertStmt = mysqli_prepare($Connection, 
        "INSERT INTO Signup (NAME, EMAIL, CONTACT, PASSWORD, C_PASSWORD, STATUS) VALUES (?, ?, ?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param($insertStmt, "ssssss", $Name, $Email, $Contact, $HashedPassword, $HashedCPassword, $Status);

    if (mysqli_stmt_execute($insertStmt)) {
        // ✅ Set session and redirect
        $_SESSION['name'] = $Name;
        $_SESSION['email'] = $Email;
        $_SESSION['status'] = $Status;

        header("Location: Home.php");
        exit();
    } else {
        echo "<script>alert('Error occurred while signing up. Try again.'); window.location='Sign_Up.php';</script>";
        exit();
    }
}
?>
