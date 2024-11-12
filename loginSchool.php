<?php
session_start(); // Start the session

include 'conn.php'; // Include the database connection

// Check if form is submitted
if (isset($_POST['loginSchool'])) {
    // Get form data
    $code = $_POST['code'];
    $civil_no = $_POST['civil_no'];

    // Prepare and bind parameters to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM schools WHERE code = ? AND (civil_no1=? or civil_no2=? or civil_no3=? or civil_no4=?)");
    $stmt->bind_param("sssss", $code, $civil_no, $civil_no, $civil_no, $civil_no);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a matching record is found
    if ($result->num_rows > 0) {
        // Fetch the user data (if needed)
        $user = $result->fetch_assoc();

        // Store user information in the session
        $_SESSION['logged_in'] = true;
        $_SESSION['school_code'] = $user['code']; // Example of storing school code
        $_SESSION['nameSchool'] = $user['name']; // Store civil number if needed
        $_SESSION['civil_no'] =   $civil_no; // Store civil number if needed


        // Successfully logged in
        echo "<script>alert('تم تسجيل الدخول بنجاح!');</script>";
        // Redirect to another page if needed
        header("Location: main.php");

        
        exit(); // Use exit to prevent further script execution after redirection
    } else {
        // Invalid credentials
        echo "<script>alert('رمز المدرسة أو الرقم المدني غير صحيح. حاول مرة أخرى.');</script>";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
