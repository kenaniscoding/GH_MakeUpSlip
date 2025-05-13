<?php
if($_POST){
    require('fpdf/fpdf.php');
    
    // Collect and sanitize form inputs
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $grade = $_POST["grade"];
    $section = $_POST["section"];
    $subject = $_POST["subject"];
    $teacher = $_POST["teacher"];
    $start_date = isset($_POST["start_date"]) ? $_POST["start_date"] : '';
    $end_date = isset($_POST["end_date"]) ? $_POST["end_date"] : '';
    $email = $_POST["email"];
    $reason = $_POST["reason"];
    
    $title = 'Student Report';
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetTitle($title);
    
    // Arial bold 15
    $pdf->SetFont('Arial','B',15);
    
    // Calculate width of title and position
    $w = $pdf->GetStringWidth($title)+6;
    $pdf->SetX((210-$w)/2);
    
    // Colors of frame, background and text
    $pdf->SetDrawColor(221,221,221,1);
    $pdf->SetFillColor(10,158,0,1);
    $pdf->SetTextColor(255,255,255,1);
    
    // Thickness of frame (1 mm)
    $pdf->SetLineWidth(1);
    
    // Title
    // Cell(width, height, content, border, nextline parametters, alignement[c - center], fill)
    $pdf->Cell($w, 9, $title, 1, 1, 'C', true);
    
    // Line break
    $pdf->Ln(10);
    $pdf->SetTextColor(0,0,0,1);
    
    // Define table width
    $tableWidth = 170;
    $labelWidth = 50;
    $valueWidth = $tableWidth - $labelWidth;
    
    // Set position for the table
    $pdf->SetX((210-$tableWidth)/2);
    
    // Student Information
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell($tableWidth, 10, 'Student Information', 1, 1, 'C', false);
    $pdf->SetX((210-$tableWidth)/2);
    
    $pdf->SetFont('Arial','',10);
    $pdf->Cell($labelWidth, 8, 'First Name:', 1, 0, 'L');
    $pdf->Cell($valueWidth, 8, $first_name, 1, 1, 'L');
    $pdf->SetX((210-$tableWidth)/2);
    
    $pdf->Cell($labelWidth, 8, 'Last Name:', 1, 0, 'L');
    $pdf->Cell($valueWidth, 8, $last_name, 1, 1, 'L');
    $pdf->SetX((210-$tableWidth)/2);
    
    $pdf->Cell($labelWidth, 8, 'Grade:', 1, 0, 'L');
    $pdf->Cell($valueWidth, 8, $grade, 1, 1, 'L');
    $pdf->SetX((210-$tableWidth)/2);
    
    $pdf->Cell($labelWidth, 8, 'Section:', 1, 0, 'L');
    $pdf->Cell($valueWidth, 8, $section, 1, 1, 'L');
    $pdf->SetX((210-$tableWidth)/2);
    
    // Class Information
    $pdf->Ln(5);
    $pdf->SetX((210-$tableWidth)/2);
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell($tableWidth, 10, 'Class Information', 1, 1, 'C', false);
    $pdf->SetX((210-$tableWidth)/2);
    
    $pdf->SetFont('Arial','',10);
    $pdf->Cell($labelWidth, 8, 'Subject:', 1, 0, 'L');
    $pdf->Cell($valueWidth, 8, $subject, 1, 1, 'L');
    $pdf->SetX((210-$tableWidth)/2);
    
    $pdf->Cell($labelWidth, 8, 'Teacher:', 1, 0, 'L');
    $pdf->Cell($valueWidth, 8, $teacher, 1, 1, 'L');
    $pdf->SetX((210-$tableWidth)/2);
    
    // Date Information
    $pdf->Ln(5);
    $pdf->SetX((210-$tableWidth)/2);
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell($tableWidth, 10, 'Date Information', 1, 1, 'C', false);
    $pdf->SetX((210-$tableWidth)/2);
    
    $pdf->SetFont('Arial','',10);
    $pdf->Cell($labelWidth, 8, 'Start Date:', 1, 0, 'L');
    $pdf->Cell($valueWidth, 8, $start_date, 1, 1, 'L');
    $pdf->SetX((210-$tableWidth)/2);
    
    $pdf->Cell($labelWidth, 8, 'End Date:', 1, 0, 'L');
    $pdf->Cell($valueWidth, 8, $end_date, 1, 1, 'L');
    $pdf->SetX((210-$tableWidth)/2);
    
    // Contact Information
    $pdf->Ln(5);
    $pdf->SetX((210-$tableWidth)/2);
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell($tableWidth, 10, 'Contact Information', 1, 1, 'C', false);
    $pdf->SetX((210-$tableWidth)/2);
    
    $pdf->SetFont('Arial','',10);
    $pdf->Cell($labelWidth, 8, 'Email:', 1, 0, 'L');
    $pdf->Cell($valueWidth, 8, $email, 1, 1, 'L');
    $pdf->SetX((210-$tableWidth)/2);
    
    // Reason
    $pdf->Ln(5);
    $pdf->SetX((210-$tableWidth)/2);
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell($tableWidth, 10, 'Request Information', 1, 1, 'C', false);
    $pdf->SetX((210-$tableWidth)/2);
    
    $pdf->SetFont('Arial','',10);
    $pdf->Cell($labelWidth, 8, 'Reason:', 1, 0, 'L');
    $pdf->MultiCell($valueWidth, 8, $reason, 1, 'L');
    
    $pdf->Output();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Student Report PDF</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .main-block {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .body form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .full-width {
            grid-column: span 2;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            cursor: pointer;
            padding: 10px;
            border: none;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="main-block">
        <div class="header">
            Student Report Generation
        </div>
        <div class="body">
            <form action='' method="POST">
                <div>
                    <input type="text" name="first_name" placeholder="First Name" required>
                </div>
                <div>
                    <input type="text" name="last_name" placeholder="Last Name" required>
                </div>
                <div>
                    <input type="text" name="grade" placeholder="Grade" required>
                </div>
                <div>
                    <input type="text" name="section" placeholder="Section" required>
                </div>
                <div>
                    <input type="text" name="subject" placeholder="Subject" required>
                </div>
                <div>
                    <input type="text" name="teacher" placeholder="Teacher" required>
                </div>
                <div>
                    <label for="start_date">Start Date:</label>
                    <input type="date" name="start_date" id="start_date">
                </div>
                <div>
                    <label for="end_date">End Date:</label>
                    <input type="date" name="end_date" id="end_date">
                </div>
                <div>
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>
                <div class="full-width">
                    <textarea name="reason" rows="4" placeholder="Reason for report" required></textarea>
                </div>
                <div class="full-width">
                    <input type="submit" value="Generate Report">
                </div>
            </form>
        </div>
        <div class="footer">
            <p>Developed by <a href="https://vicodemedia.com" target="_blank">Vicode Media</a></p>
        </div>
    </div>
</body>
</html>