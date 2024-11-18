<?php

                                                       // Function to sanitize input
function validate_input($data) {
    return htmlspecialchars(trim($data));  
}

                                                        // Function to validate student name (only letters and spaces)
function validate_name($name) {
    return preg_match("/^[a-zA-Z\s]+$/", $name);  
}

                                                         // Function to validate student ID (format ##-#####-##)
function validate_student_id($student_id) {
    return preg_match("/^\d{2}-\d{5}-\d{2}$/", $student_id);  
}

                                                          // Function to validate ISBN (basic format, can be expanded)
function validate_isbn($isbn) {
    return preg_match("/^\d{13}$/", $isbn);  // A simple 13-digit ISBN check
}

                                                           // Function to validate count (must be a positive integer)
function validate_count($count) {
    return filter_var($count, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);
}

                                                              // Function to validate category (check if it's a valid option)
function validate_category($category) {
    $valid_categories = ["Fiction", "Non-Fiction", "Science", "Math", "Technology", "History"];
    return in_array($category, $valid_categories);
}

                                                                             // Processing form when it's submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

                                                                                 // Get values from the form
    $student_name = validate_input($_POST['student-name']);
    $student_id = validate_input($_POST['student-id']);
    $book_title = validate_input($_POST['book-title']);
    $borrow_date = validate_input($_POST['borrow-date']);
    $token = validate_input($_POST['token']);
    $return_date = validate_input($_POST['return-date']);
    $fees = validate_input($_POST['fees']);
    $paid = validate_input($_POST['paid']);
    
                                                                             // New book information form fields
    $book_name = validate_input($_POST['book-name']);
    $author = validate_input($_POST['author']);
    $isbn = validate_input($_POST['isbn']);
    $count = validate_input($_POST['count']);
    $category = validate_input($_POST['category']);
    
                                                                                   // Initialize an array for errors
    $errors = [];

                                                                                      // Validate the fields for borrow form
    if (!validate_name($student_name)) {
        $errors[] = "Student name should only contain letters and spaces.";
    }

    if (!validate_student_id($student_id)) {
        $errors[] = "Student ID should be in the format ##-#####-##.";
    }

    if (empty($book_title)) {
        $errors[] = "Please select a book title.";
    }

    if (empty($borrow_date)) {
        $errors[] = "Please select a borrow date.";
    }

    if (empty($token)) {
        $errors[] = "Please enter a token.";
    }

    if (empty($return_date)) {
        $errors[] = "Please select a return date.";
    }

    if (!is_numeric($fees) || $fees < 0) {
        $errors[] = "Fees must be a positive number.";
    }

    if (!in_array($paid, ["Yes", "No"])) {
        $errors[] = "Please select whether the fees are paid or not.";
    }

                                                                       // Validate the fields for the book information form
    if (empty($book_name)) {
        $errors[] = "Please enter a book name.";
    }

    if (empty($author)) {
        $errors[] = "Please enter the author's name.";
    }

    if (!validate_isbn($isbn)) {
        $errors[] = "ISBN must be 13 digits long.";
    }

    if (!validate_count($count)) {
        $errors[] = "Count must be a positive integer.";
    }

    if (!validate_category($category)) {
        $errors[] = "Please select a valid category.";
    }

                                                               // If there are no errors, proceed with saving the data
    if (empty($errors)) {

                                                               // Prepare the data array
        $data = [
            "Student Name" => $student_name,
            "Student ID" => $student_id,
            "Book Title" => $book_title,
            "Borrow Date" => $borrow_date,
            "Token" => $token,
            "Return Date" => $return_date,
            "Fees" => $fees,
            "Paid" => $paid,
            "Book Name" => $book_name,
            "Author" => $author,
            "ISBN" => $isbn,
            "Count" => $count,
            "Category" => $category
        ];

                                                                             // File to store the submissions
        $file = 'submissions.txt';  

                                                                              // Open the file for appending
        $handle = fopen($file, 'a');
        if ($handle) {
                                                                                // Format the data as JSON and write it to the file
            $formatted_data = json_encode($data) . PHP_EOL; 
            fwrite($handle, $formatted_data);
            fclose($handle);

                                                                               // Success message
            echo "<h2>Form submitted successfully!</h2>";
        } else {
                                                                              // Error saving data
            $errors[] = "Error saving data to file.";
        }
    }

                                                                                   // If there are errors, display them
    if (!empty($errors)) {
        echo "<h2>There were errors with your submission:</h2><ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
}

?>
