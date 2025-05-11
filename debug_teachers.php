<?php
// Debug script to check what's happening with the query
// Put this in a new file called debug_teachers.php

// Disable error reporting for production, enable for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("localhost", "root", "", "db");

// Check connection
if ($conn->connect_error) {
    die("Connection Error: " . $conn->connect_error);
}

// Get the selected subject and grade level from GET parameters for easier testing
$subject = isset($_GET['subject']) ? $conn->real_escape_string($_GET['subject']) : '';
$grade = isset($_GET['grade']) ? $conn->real_escape_string($_GET['grade']) : '';

echo "<h2>Debug Information</h2>";
echo "<p>Subject: '$subject'</p>";
echo "<p>Grade Level: '$grade'</p>";

// Show all teachers in the database for comparison
echo "<h3>All Teachers in Database:</h3>";
$allTeachers = $conn->query("SELECT * FROM teachers");
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Subject</th>
            <th>Grade Level</th>
        </tr>";

if ($allTeachers && $allTeachers->num_rows > 0) {
    while ($row = $allTeachers->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['teacher_id'] . "</td>
                <td>" . htmlspecialchars($row['teacher_name']) . "</td>
                <td>" . htmlspecialchars($row['subject']) . "</td>
                <td>" . htmlspecialchars($row['grade_level']) . "</td>
             </tr>";
    }
} else {
    echo "<tr><td colspan='4'>No teachers found in database</td></tr>";
}
echo "</table>";

// Query to get teachers based on subject and grade level
$query = "SELECT * FROM teachers 
          WHERE subject = '$subject' 
          AND grade_level = '$grade'";

echo "<h3>Query Used:</h3>";
echo "<pre>" . htmlspecialchars($query) . "</pre>";

$result = $conn->query($query);

echo "<h3>Matching Teachers:</h3>";
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Subject</th>
            <th>Grade Level</th>
        </tr>";

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['teacher_id'] . "</td>
                <td>" . htmlspecialchars($row['teacher_name']) . "</td>
                <td>" . htmlspecialchars($row['subject']) . "</td>
                <td>" . htmlspecialchars($row['grade_level']) . "</td>
             </tr>";
    }
} else {
    echo "<tr><td colspan='4'>No matching teachers found</td></tr>";
}
echo "</table>";

// Close the database connection
$conn->close();
?>