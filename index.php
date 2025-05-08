<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSGH Makeup Quiz Request Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
// // Run only if the form is submitted
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $conn = new mysqli("localhost", "root", "", "db2");
//     // Check connection
//     if ($conn->connect_error) {
//         die("<div class='error-message'>Connection failed: " . $conn->connect_error . "</div>");
//     }
//     // Collect and sanitize form inputs
//     $first_name = $conn->real_escape_string($_POST["first_name"]);
//     $last_name = $conn->real_escape_string($_POST["last_name"]);
//     $grade = $conn->real_escape_string($_POST["grade"]);
//     $section = $conn->real_escape_string($_POST["section"]);
//     $subject = $conn->real_escape_string($_POST["subject"]);
//     $teacher = $conn->real_escape_string($_POST["teacher"]);
//     $quiz_date = isset($_POST["quiz_date"]) ? $conn->real_escape_string($_POST["quiz_date"]) : '';
//     // Insert query
//     $sql = "INSERT INTO makeup_slips (first_name, last_name, grade_level, section, subject, teacher_name, quiz_date)
//             VALUES ('$first_name', '$last_name', '$grade', '$section', '$subject', '$teacher', '$quiz_date')";
//     if ($conn->query($sql) === TRUE) {
//         echo "<div class='success-message'>Makeup slip submitted successfully!</div>";
//     } else {
//         echo "<div class='error-message'>Error: " . $conn->error . "</div>";
//     }
//     $conn->close();
// }
?>

<div class="container">
    <div class="header">
        <h2>LSGH Makeup Quiz Request Form</h2>
    </div>
    
    <form method="POST" action="check.php">
        <div class="form-row">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="grade">Grade Level</label>
                <select id="grade" name="grade" required>
                    <option value="Kinder">Kinder</option>
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="Grade <?= $i ?>">Grade <?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="section">Section</label>
                <select id="section" name="section" required>
                    <?php foreach (range('A', 'O') as $sec): ?>
                        <option value="<?= $sec ?>"><?= $sec ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label for="subject">Subject</label>
            <select id="subject" name="subject" required>
                <option value="English">English</option>
                <option value="Filipino">Filipino</option>
                <option value="Math">Math</option>
                <option value="Science">Science</option>
                <option value="AP">AP</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="teacher">Teacher's Name</label>
            <input type="text" id="teacher" name="teacher" required>
        </div>
        
        <div class="form-group">
            <label for="quiz_date">Date of Quiz</label>
            <input type="date" id="quiz_date" name="quiz_date" required>
        </div>
        
        <button type="submit">Submit Makeup Slip
        </button>
    </form>
</div>
</body>
</html>