<html>
<body>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Makeup Slip Form</title>
    <link rel="stylesheet" href="style.css">
<?php
// Run only if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "db2");
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
    $quiz_date = isset($_POST["quiz_date"]) ? $conn->real_escape_string($_POST["quiz_date"]) : '';
    // Insert query
    $sql = "INSERT INTO makeup_slips (first_name, last_name, grade_level, section, subject, teacher_name, quiz_date)
            VALUES ('$first_name', '$last_name', '$grade', '$section', '$subject', '$teacher', '$quiz_date')";
    if ($conn->query($sql) === TRUE) {
        echo "
        <div class='container'>
        <div class='header'>
        <h2>Thank You!</h2>
        </div>
        <div class='success-message'>
        Your submission has been received successfully. We appreciate your time and effort!
        </div>
        <p>We’ll get back to you as soon as possible. If you have any further questions, feel free to contact us anytime.</p>
        </div>
        ";
    } else {
        echo "<div class='error-message'>Error: " . $conn->error . "</div>";
    }
    $conn->close();
}
?>
</body>
</html>