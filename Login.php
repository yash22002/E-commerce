<?php
session_start();
include("Connection.php");
include("Table_Creation.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email']) && isset($_POST['password'])) {
    $Email = trim($_POST['email']);
    $Password = $_POST['password'];

    // ✅ Secure query using prepared statements
    $Query = "SELECT NAME, EMAIL, PASSWORD FROM Signup WHERE EMAIL = ?";
    $stmt = mysqli_prepare($Connection, $Query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $Email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($Row = mysqli_fetch_assoc($result)) {
            $StoredHash = $Row['PASSWORD'];

            // ✅ Verify the password
            if (password_verify($Password, $StoredHash)) {
                // ✅ Set session variables
                $_SESSION['name'] = $Row['NAME'];
                $_SESSION['email'] = $Row['EMAIL'];
                $_SESSION['status'] = "Online";

                // ✅ Update user status to "Online"
                $Status = "Online";
                $Update = "UPDATE Signup SET STATUS = ? WHERE EMAIL = ?";
                $updateStmt = mysqli_prepare($Connection, $Update);
                mysqli_stmt_bind_param($updateStmt, "ss", $Status, $Email);
                mysqli_stmt_execute($updateStmt);

                // ✅ Redirect to Home.php
                header("Location: Home.php");
                exit();
            } else {
                // ❌ Wrong password
                echo "<script>alert('Incorrect password'); window.location='Log-in.php';</script>";
                exit();
            }
        } else {
            // ❌ Email not found
            echo "<script>alert('Account not found'); window.location='Log-in.php';</script>";
            exit();
        }
    } else {
        // ❌ Query preparation failed
        echo "<script>alert('Server error, please try again'); window.location='Log-in.php';</script>";
        exit();
    }
} else {
    // ❌ Invalid form submission
    header("Location: Log-in.php");
    exit();
}
?>
