<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "db");

// Check connection
if ($conn->connect_error) {
    die("<div class='error-message'>Connection failed: " . $conn->connect_error . "</div>");
}
/////////////////////////////////////////////////////////////////////////////////
// Run only if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "db");

    // Check connection
    if ($conn->connect_error) {
        die("<div class='error-message'>Connection failed: " . $conn->connect_error . "</div>");
    }

    // Collect and sanitize form inputs
    $first_name = $conn->real_escape_string($_POST["first_name"]);
    $last_name = $conn->real_escape_string($_POST["last_name"]);
    $grade = $conn->real_escape_string($_POST["grade"]);
    $section = $conn->real_escape_string($_POST["section"]);
    $subject = $conn->real_escape_string($_POST["subject"]);
    $teacher = $conn->real_escape_string($_POST["teacher"]);
    $start_date = isset($_POST["start_date"]) ? $conn->real_escape_string($_POST["start_date"]) : '';
    $end_date = isset($_POST["end_date"]) ? $conn->real_escape_string($_POST["end_date"]) : '';
    $email = $conn->real_escape_string($_POST["email"]); // NEW: get and sanitize email
    $reason = $conn->real_escape_string($_POST["reason"]); // NEW: get and sanitize email

    // Insert query with email
    $sql = "INSERT INTO makeup_slips (first_name, last_name, grade_level, section, subject, teacher_name, start_date, end_date, email, reason)
            VALUES ('$first_name', '$last_name', '$grade', '$section', '$subject', '$teacher', '$start_date', '$end_date', '$email', '$reason')";

    if ($conn->query($sql) === TRUE) {
        // Send email to the inputted email address (user)
        // THIS IS THE STUDENT/PARENT'S EMAIL CONTENT
        $userSubject = "Makeup Slip Submission Confirmation";
        $userBody = "Dear $first_name $last_name,\n\nThank you for your submission. This is a confirmation that we have received your makeup slip request for $subject under $teacher scheduled on $start_date.\n\nWe will contact you if further information is needed.\n\nBest regards,\nAcademic Office";

        // Call the sendEmail function to notify the user
        // Send confirmation email to the student
        sendEmail($email, $userSubject, $userBody);

        // Now send the same email to the specific teacher selected
        $teacherEmailQuery = "SELECT email FROM teachers WHERE teacher_name = '$teacher' LIMIT 1";
        $teacherEmailResult = $conn->query($teacherEmailQuery);

        if ($teacherEmailResult && $teacherEmailResult->num_rows > 0) {
            $teacherRow = $teacherEmailResult->fetch_assoc();
            $teacherEmail = $teacherRow['email'];
            // THIS IS THE TEACHER'S EMAIL CONTENT
            $teacherSubject = "Makeup Slip Request Notification";
            $teacherBody = "Dear $teacher,\n\nA new makeup slip request has been submitted by $first_name $last_name for the subject $subject scheduled on $start_date.\n\nPlease review this request at your earliest convenience.\n\nBest regards,\nAcademic Office";

            sendEmail($teacherEmail, $teacherSubject, $teacherBody);
        }

        echo "
        <div class='container'>
            <div class='header'>
                <h2>Thank You!</h2>
            </div>
            <div class='success-message'>
                Your submission has been received successfully. A confirmation email has been sent to <strong>$email</strong>.
            </div>
            <p>We’ll get back to you as soon as possible. If you have any further questions, feel free to contact us anytime.</p>
        </div>
        ";
    }


    // $conn->close();
}
/////////////////////////////////////////////////////////////////////////////////
// Function to get table structure
function getTableColumns($conn, $tableName) {
    $columns = [];
    $query = "SHOW COLUMNS FROM $tableName";
    $result = $conn->query($query);
    
    if ($result) {
        while($row = $result->fetch_assoc()) {
            $columns[] = $row['Field'];
        }
    }
    return $columns;
}

// Function to send email
function sendEmail($receiver, $subject, $body) {
    $sender = "From: kenanbanal3@gmail.com";
    
    if(mail($receiver, $subject, $body, $sender)) {
        return true;
    } else {
        return false;
    }
}

// Get all tables in the database
$tablesResult = $conn->query("SHOW TABLES");
$tables = [];
if ($tablesResult) {
    while ($row = $tablesResult->fetch_row()) {
        $tables[] = $row[0];
    }
}

// Check if teachers table exists
$teachersTableExists = in_array('teachers', $tables);

$teacherColumns = [];
$teacherData = [];
$message = "";
$results = [];

// Get teacher table columns if it exists
if ($teachersTableExists) {
    $teacherColumns = getTableColumns($conn, 'teachers');
    
    // Check if the table has an email column
    if (in_array('email', $teacherColumns)) {
        // Get all teacher data
        $teacherQuery = "SELECT * FROM teachers";
        $teacherResult = $conn->query($teacherQuery);
        
        if ($teacherResult && $teacherResult->num_rows > 0) {
            while($row = $teacherResult->fetch_assoc()) {
                $teacherData[] = $row;
            }
        }
    } else {
        $message = "The 'teachers' table does not have an 'email' column.";
    }
} else {
    $message = "The 'teachers' table does not exist in the database.";
    
    // Let's try to find a table that might contain teacher information
    foreach ($tables as $table) {
        $columns = getTableColumns($conn, $table);
        if (in_array('email', $columns) || in_array('teacher_email', $columns) || 
            in_array('teacher_name', $columns) || in_array('name', $columns)) {
            $message .= " Found table '$table' that might contain teacher information.";
            break;
        }
    }
}

// Determine name column
$nameColumn = null;
if (!empty($teacherColumns)) {
    $nameOptions = ['teacher_name', 'name', 'full_name', 'first_name', 'lastname', 'last_name'];
    foreach ($nameOptions as $option) {
        if (in_array($option, $teacherColumns)) {
            $nameColumn = $option;
            break;
        }
    }
}

?>

<!-- <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSGH Make Up Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class='container'>
            <div class='header'>
                <h2>Thank You!</h2>
            </div>
            <div class='success-message'>
                Your submission has been received successfully. We appreciate your time and effort!
            </div>
            <p>We’ll get back to you as soon as possible. If you have any further questions, feel free to contact us anytime.</p>
    </div>
</body>
</html> -->

<?php
// Close the database connection
$conn->close();
?>