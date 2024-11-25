<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentName = $_POST['student-name'];
    $email = $_POST['email'];
    $studentId = $_POST['student-id'];
    $bookTitle = $_POST['book-title'];
    $borrowDate = $_POST['borrow-date'];
    $returnDate = $_POST['return-date'];
    $token = isset($_POST['token']) ? $_POST['token'] : null;
    $fees = $_POST['fees'];
    $paid = $_POST['paid'];

    $borrowDateObj = new DateTime($borrowDate);
    $returnDateObj = new DateTime($returnDate);
    $dateDifference = $borrowDateObj->diff($returnDateObj)->days;

    if (isset($_COOKIE[$bookTitle])) {
        $expiry = $_COOKIE[$bookTitle];
        $remainingDays = (strtotime($expiry) - time()) / (60 * 60 * 24);

        if ($remainingDays > 0) {
            echo "<p style='color:red;'>The book '$bookTitle' is currently borrowed. Please wait for " . ceil($remainingDays) . " days.</p>";
            exit;
        }
    }

    if ($dateDifference > 10) {
        if (empty($token)) {
            echo "<p style='color:red;'>Token is required for borrowing over 10 days.</p>";
            exit;
        }
    }

$sanitizedBookTitle = preg_replace('/[^A-Za-z0-9_\-]/', '_', $bookTitle);

if (isset($_COOKIE[$sanitizedBookTitle])) {
    $expiry = $_COOKIE[$sanitizedBookTitle];
    $remainingSeconds = strtotime($expiry) - time();

    if ($remainingSeconds > 0) {
        $remainingMinutes = ceil($remainingSeconds / 60);
        echo "<p style='color:red;'>The book '$bookTitle' is currently borrowed. Please wait for $remainingMinutes minute(s).</p>";
        exit;
    }
}

$cookieExpiry = time() + (3 * 60);
setcookie($sanitizedBookTitle, date('Y-m-d H:i:s', $cookieExpiry), $cookieExpiry);

echo "<h2>Receipt</h2>";
echo "<p>Student Name: $studentName</p>";
echo "<p>Email: $email</p>";
echo "<p>Student ID: $studentId</p>";
echo "<p>Book Title: $bookTitle</p>";
echo "<p>Borrow Date: $borrowDate</p>";
echo "<p>Return Date: $returnDate</p>";
echo "<p>Fees: $$fees</p>";
echo "<p>Paid: $paid</p>";
echo "<p style='color:green;'>Book borrowed successfully! The book will be available for borrowing again in 3 minutes.</p>";

}
?>

