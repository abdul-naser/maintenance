<?php
session_start(); // Start the session

include 'conn.php'; // Include the database connection

// Check if form is submitted
if (isset($_POST['loginSchool'])) {
    // Get form data
    $password = $_POST['password'];

    // Prepare and bind parameters to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM login_section WHERE password = ?");
    $stmt->bind_param("s", $password);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a matching record is found
    if ($result->num_rows > 0) {
        // Fetch the user data (if needed)
        $user = $result->fetch_assoc();

        // Store user information in the session
        $_SESSION['logged_section'] = true;
        $_SESSION['SectionID'] = $user['SectionID'];
        $_SESSION['noSection'] = $user['no'];

        $_SESSION['section'] = $user['department_name'];


        // Successfully logged in
        echo "<script>alert('تم تسجيل الدخول بنجاح!');</script>";
        // Redirect to another page if needed
        header("Location: main.php");

        
        exit(); // Use exit to prevent further script execution after redirection
    } else {
        // Invalid credentials
        echo "<script>alert('رمز  السري  غير صحيح. حاول مرة أخرى.');</script>";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
