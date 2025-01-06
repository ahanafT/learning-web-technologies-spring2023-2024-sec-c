<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentName = $_POST['student-name'];
    $email = $_POST['email'];
    $studentId = $_POST['student-id'];
    $borrowDate = $_POST['borrow-date'];
    $returnDate = $_POST['return-date'];
    $fees = $_POST['fees'];
    $paid = $_POST['paid'];

    $bookName = $_POST['book-name'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $count = $_POST['count'];
    $category = $_POST['category'];

    if (isset($_COOKIE[$bookName])) {
        echo "<p style='color:red;'>The book '$bookName' is currently unavailable. Please wait for 10 days.</p>";
    } else {

        $borrowDateObj = new DateTime($borrowDate);
        $returnDateObj = new DateTime($returnDate);
        $dateDifference = $borrowDateObj->diff($returnDateObj)->days;

        if ($dateDifference > 10) {
            if (empty($_POST['token'])) {
                echo "<p style='color:red;'>Token is required for borrowing over 10 days.</p>";
                exit;
            }
        }
        setcookie($bookName, $studentName, time() + (10 * 24 * 60 * 60)); 

        echo "<h2>Receipt</h2>";
        echo "<p>Student Name: $studentName</p>";
        echo "<p>Email: $email</p>";
        echo "<p>Student ID: $studentId</p>";
        echo "<p>Book: $bookName</p>";
        echo "<p>Author: $author</p>";
        echo "<p>ISBN: $isbn</p>";
        echo "<p>Category: $category</p>";
        echo "<p>Borrow Date: $borrowDate</p>";
        echo "<p>Return Date: $returnDate</p>";
        echo "<p>Fees: $$fees</p>";
        echo "<p>Paid: $paid</p>";
        echo "<p>Thank you for borrowing the book. Enjoy reading!</p>";
    }
}
?>