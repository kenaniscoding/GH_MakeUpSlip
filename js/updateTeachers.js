// Form submission with loading popup
document.getElementById('makeupQuizForm').addEventListener('submit', function(e) {
    // Show loading overlay
    document.getElementById('loadingOverlay').style.display = 'flex';
    
    // Add disabled class to form to prevent user interaction
    document.querySelector('.container').classList.add('form-disabled');
    
    // Change submit button text
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.innerHTML = 'Submitting...';
    submitBtn.disabled = true;
});

// Optional: Hide loading overlay if there's an error or if user navigates back
window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
        // Page was loaded from cache (user pressed back button)
        document.getElementById('loadingOverlay').style.display = 'none';
        document.querySelector('.container').classList.remove('form-disabled');
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.innerHTML = 'Submit Makeup Slip';
        submitBtn.disabled = false;
    }
});

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