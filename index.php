<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSGH Makeup Quiz Request Form</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "db2");
// Check connection
if ($conn->connect_error) {
    die("<div class='error-message'>Connection failed: " . $conn->connect_error . "</div>");
}

// Run only if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        echo "<div class='success-message'>Makeup slip submitted successfully!</div>";
    } else {
        echo "<div class='error-message'>Error: " . $conn->error . "</div>";
    }
}

// For debugging, let's see what values are in the database
$teachersDebug = $conn->query("SELECT DISTINCT subject FROM teachers ORDER BY subject");
$subjectsInDB = [];
if ($teachersDebug && $teachersDebug->num_rows > 0) {
    while ($row = $teachersDebug->fetch_assoc()) {
        $subjectsInDB[] = $row['subject'];
    }
}

$gradesDebug = $conn->query("SELECT DISTINCT grade_level FROM teachers ORDER BY grade_level");
$gradesInDB = [];
if ($gradesDebug && $gradesDebug->num_rows > 0) {
    while ($row = $gradesDebug->fetch_assoc()) {
        $gradesInDB[] = $row['grade_level'];
    }
}
?>

<div class="container">
    <div class="header">
        <h2>LSGH Makeup Quiz Request Form</h2>
    </div>
    
    <form method="POST" action="teachers_email.php">
        <!-- Data Privacy Agreement Checkbox -->
        <div class="form-check mb-3" style="display: flex; align-items: flex-start; gap: 10px;">
        <input class="form-check-input" type="checkbox" id="privacy_agree" name="privacy_agree" required style="margin-top: 4px;">
        <label class="form-check-label" for="privacy_agree" style="font-weight: 400; line-height: 1.4;">
            I agree to the <strong>Data Privacy Act</strong> terms and conditions regarding the 
            collection and use of my personal information.
        </label>
        </div>


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
                    <?php 
                    // Instead of hardcoding values, use what's in the database
                    if (!empty($gradesInDB)) {
                        foreach ($gradesInDB as $grade) {
                            echo '<option value="' . htmlspecialchars($grade) . '">' . htmlspecialchars($grade) . '</option>';
                        }
                    } else {
                        // Fallback to original values if no data in DB
                        echo '<option value="Kinder">Kinder</option>';
                        for ($i = 1; $i <= 12; $i++) {
                            echo '<option value="Grade ' . $i . '">Grade ' . $i . '</option>';
                        }
                    }
                    ?>
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
        
        <div class="form-group" style="margin-bottom: 1rem;">
        <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">
            Email Address
        </label>
        <input 
            type="email" 
            id="email" 
            name="email" 
            required 
            placeholder="Enter your email address"
            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
            style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;"
        >
        </div>


        <div class="form-group">
            <label for="subject">Subject</label>
            <select id="subject" name="subject" required>
                <?php 
                // Instead of hardcoding values, use what's in the database
                if (!empty($subjectsInDB)) {
                    foreach ($subjectsInDB as $subject) {
                        echo '<option value="' . htmlspecialchars($subject) . '">' . htmlspecialchars($subject) . '</option>';
                    }
                } else {
                    // Fallback to original values if no data in DB
                    echo '<option value="English">English</option>';
                    echo '<option value="Filipino">Filipino</option>';
                    echo '<option value="Math">Math</option>';
                    echo '<option value="Science">Science</option>';
                    echo '<option value="AP">AP</option>';
                }
                ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="teacher">Teacher's Name</label>
            <select id="teacher" name="teacher" required>
                <option value="">Select subject and grade level first</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="quiz_date">Date of Missed Quiz</label>
            <input type="date" id="quiz_date" name="quiz_date" max="<?php echo date('Y-m-d'); ?>" required>
        </div>
        
        <button type="submit">Submit Makeup Slip</button>
    </form>
    
    <!-- Debug info (hidden in production) -->
    <!-- <div style="margin-top: 20px; padding: 10px; border: 1px solid #ddd; background: #f9f9f9;">
        <h3>Debug Information:</h3>
        <p>Subjects in database: <?php echo implode(", ", $subjectsInDB); ?></p>
        <p>Grades in database: <?php echo implode(", ", $gradesInDB); ?></p>
    </div> -->
</div>

<script>
$(document).ready(function() {
    // Function to update teachers dropdown based on subject and grade selection
    function updateTeachers() {
        var subject = $('#subject').val();
        var grade = $('#grade').val();
        
        console.log("Selected Subject:", subject);
        console.log("Selected Grade:", grade);
        
        // Skip the request if either field is empty
        if (!subject || !grade) {
            $('#teacher').html('<option value="">Please select both subject and grade</option>');
            return;
        }
        
        // Reset teacher dropdown
        $('#teacher').html('<option value="">Loading teachers...</option>');
        
        // AJAX request to get teachers based on subject and grade
        $.ajax({
            url: 'get_teachers.php',
            type: 'POST',
            dataType: 'html',
            data: {
                subject: subject,
                grade: grade
            },
            success: function(response) {
                console.log("Response received:", response);
                $('#teacher').html(response);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                console.log("Response text:", xhr.responseText);
                $('#teacher').html('<option value="">Error loading teachers</option>');
            }
        });
    }
    
    // Update teachers when subject or grade changes
    $('#subject, #grade').change(function() {
        updateTeachers();
    });
    
    // For debugging purposes - show the current selections
    $('#subject, #grade').change(function() {
        console.log("Updated selections - Subject:", $('#subject').val(), "Grade:", $('#grade').val());
    });
});
</script>

<?php
// Close the database connection
$conn->close();
?>
</body>
</html>