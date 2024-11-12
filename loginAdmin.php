<?php
session_start(); // Start the session

include 'conn.php'; // Include the database connection

// Check if form is submitted
if (isset($_POST['loginAdmin'])) {
    // Get form data
    $adminUsername = $_POST['adminUsername'];
    $adminPassword = $_POST['adminPassword'];

    // Prepare and bind parameters to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM login_admin_maintenance WHERE username = ? AND password=?");
    $stmt->bind_param("ss", $adminUsername, $adminPassword);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a matching record is found
    if ($result->num_rows > 0) {
        // Fetch the user data (if needed)
        $user = $result->fetch_assoc();

        // Store user information in the session
        $_SESSION['logged_admin'] = true;
        $_SESSION['nameAdmin']= $user['name']; 
        $_SESSION['role']= $user['role']; 

 


        // Successfully logged in
        echo "<script>alert('تم تسجيل الدخول بنجاح!');</script>";
        // Redirect to another page if needed
        header("Location: main.php");
        exit(); // Use exit to prevent further script execution after redirection
    } else {
        // Invalid credentials
        echo "<script>alert('فشل في تسجيل الدخول');</script>";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
