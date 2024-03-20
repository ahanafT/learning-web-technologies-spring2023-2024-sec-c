<!DOCTYPE html>
<html>
<head>
    <title>Progress Tracking</title>
</head>
<body>
    <h1>Progress Tracking</h1>
    
    <!-- User Interface -->
    <div>
        <h2>Upload Progress</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="progress_file">
            <input type="submit" name="upload" value="Upload">
        </form>
    </div>

    <?php
    // Model
    class ProgressTracker {
        public static function uploadProgress($file) {
            $target_dir = "progress/";
            $target_file = $target_dir . basename($file["name"]);
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                return $target_file;
            } else {
                return false;
            }
        }
    }

    // Controller
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload'])) {
        if ($_FILES['progress_file']['error'] == UPLOAD_ERR_OK) {
            $uploaded_file = ProgressTracker::uploadProgress($_FILES['progress_file']);
            if ($uploaded_file) {
                echo "<p>Progress uploaded successfully: <a href='$uploaded_file'>" . basename($uploaded_file) . "</a></p>";
            } else {
                echo "<p>Sorry, there was an error uploading your progress file.</p>";
            }
        }
    }
    ?>

    <!-- Session -->
    <?php
    session_start();
    if (!isset($_SESSION['progress'])) {
        $_SESSION['progress'] = [];
    }

    if (isset($_POST['add_progress'])) {
        $new_progress = $_POST['new_progress'];
        array_push($_SESSION['progress'], $new_progress);
    }

    echo "<h2>Your Progress</h2>";
    echo "<ul>";
    foreach ($_SESSION['progress'] as $progress) {
        echo "<li>$progress</li>";
    }
    echo "</ul>";
    ?>

    <!-- Cookie -->
    <?php
    $cookie_name = "progress_user";
    $cookie_value = "Alice";
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
    if(!isset($_COOKIE[$cookie_name])) {
        echo "<p>Cookie named '" . $cookie_name . "' is not set!</p>";
    } else {
        echo "<p>Cookie '" . $cookie_name . "' is set!</p>";
        echo "<p>Welcome " . $_COOKIE[$cookie_name] . "!</p>";
    }
    ?>

    <!-- Form Validation -->
    <script>
    function validateForm() {
        var fileInput = document.forms["uploadForm"]["progress_file"].value;
        if (fileInput == "") {
            alert("Please select a file to upload");
            return false;
        }
    }
    </script>

</body>
</html>
