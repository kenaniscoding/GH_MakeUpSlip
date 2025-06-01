<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSGH Makeup Quiz Request Form</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
    /* Loading Overlay Styles */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-popup {
            background-color: white;
            padding: 30px 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            max-width: 300px;
            width: 90%;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-text {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .loading-subtext {
            font-size: 14px;
            color: #666;
            line-height: 1.4;
        }

        /* Disable form during submission */
        .form-disabled {
            pointer-events: none;
            opacity: 0.6;
        }
    </style>
</head>
<body>
<?php
// Database connection
$conn = new mysqli("localhost", "root", "onelasalle", "db");
// Check connection
if ($conn->connect_error) {
    die("<div class='error-message'>Connection failed: " . $conn->connect_error . "</div>");
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

<!-- Loading Overlay -->
<div id="loadingOverlay" class="loading-overlay">
    <div class="loading-popup">
        <div class="loading-spinner"></div>
        <div class="loading-text">Processing Your Request</div>
        <div class="loading-subtext">Please wait while we submit your makeup quiz request. This may take a few moments...</div>
    </div>
</div>

<div class="container">
    <div class="header">
        <h2>LSGH Makeup Quiz Request Form</h2>
    </div>
    
    <form id="makeupQuizForm" method="POST" action="teachers_email.php">
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
        <label for="email">
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

        <div class="form-group" style="margin-bottom: 1rem;">
        <label for="reason">
            Reason of Absence
        </label>
        <input 
            type="text" 
            id="reason" 
            name="reason" 
            required 
            placeholder="Enter your reason for absence"
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
            <label for="start_date">Start Absent Date</label>
            <input type="date" id="start_date" name="start_date" max="<?php echo date('Y-m-d'); ?>" required>
        </div>

        <div class="form-group">
            <label for="end_date">End Absent Date</label>
            <input type="date" id="end_date" name="end_date" max="<?php echo date('Y-m-d'); ?>" required>
        </div>
        
        <button type="submit" id="submitBtn">Submit Makeup Slip</button>
    </form>
    
    <!-- Debug info (hidden in production) -->
    <div style="margin-top: 20px; padding: 10px; border: 1px solid #ddd; background: #f9f9f9;">
        <h3>Send us Feedback at:</h3>
        <!-- <p>Subjects in database: <?php echo implode(", ", $subjectsInDB); ?></p>
        <p>Grades in database: <?php echo implode(", ", $gradesInDB); ?></p> -->
        <p style="font-family: Arial, sans-serif; color: #333;">edtech@lsgh.edu.ph</p>
    </div>
</div>

<script>

</script>

<script src="js/updateTeachers.js"></script>

<?php
// Close the database connection
$conn->close();
?>
</body>
</html>