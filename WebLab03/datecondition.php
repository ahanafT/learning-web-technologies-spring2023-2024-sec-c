
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $studentName = $_POST['student-name'];
    $email = $_POST['email'];
    $studentId = $_POST['student-id'];
    $bookTitle = $_POST['book-title'];
    $borrowDate = $_POST['borrow-date'];
    $returnDate = $_POST['return-date'];
    $token = isset($_POST['token']) ? $_POST['token'] : null;
    $fees = $_POST['fees'];
    $paid = $_POST['paid'];

    // Convert borrow and return dates to DateTime objects
    $borrowDateObj = new DateTime($borrowDate);
    $returnDateObj = new DateTime($returnDate);
    
    // Calculate the difference in days between the two dates
    $dateDifference = $borrowDateObj->diff($returnDateObj)->days;
    
    // Check if the difference is more than 10 days
    if ($dateDifference > 10) {
        // Check if token is provided
        if (empty($token)) {
            echo "<p style='color:red;'>Token is required for borrowing over 10 days.</p>";
            // Stop further processing if token is missing
            exit;
        }
    }

    // If validation passes, proceed with further processing (e.g., save to database)
    echo "<p>Form submitted successfully!</p>";
    // Database insertion or other logic here
}
?>