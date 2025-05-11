<?php
// get_teachers.php - Script to fetch teachers based on subject and grade level
// Enabling error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("localhost", "root", "", "db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Log AJAX request data
$postData = print_r($_POST, true);
error_log("POST data: " . $postData);

// Get the selected subject and grade level from AJAX request
$subject = isset($_POST['subject']) ? $_POST['subject'] : '';
$grade = isset($_POST['grade']) ? $_POST['grade'] : '';

// Remove any potential SQL injection threats (better safe than sorry)
$subject = $conn->real_escape_string($subject);
$grade = $conn->real_escape_string($grade);

// Log what we received after sanitization
error_log("Looking for teachers with subject='$subject' and grade_level='$grade'");

// Query to get teachers based on subject and grade level
$query = "SELECT * FROM teachers 
          WHERE subject = '$subject' 
          AND grade_level = '$grade'";

error_log("Query: $query");

$result = $conn->query($query);

// Log query result
if (!$result) {
    error_log("Query error: " . $conn->error);
}

// Generate options for the dropdown
if ($result && $result->num_rows > 0) {
    echo '<option value="">Select a teacher</option>';
    while ($row = $result->fetch_assoc()) {
        $teacher_name = htmlspecialchars($row["teacher_name"]);
        echo '<option value="' . $teacher_name . '">' . $teacher_name . '</option>';
    }
    error_log("Found " . $result->num_rows . " matching teachers");
} else {
    echo '<option value="">No teachers found for this subject and grade</option>';
    error_log("No matching teachers found");
}

// Close the database connection
$conn->close();
?>