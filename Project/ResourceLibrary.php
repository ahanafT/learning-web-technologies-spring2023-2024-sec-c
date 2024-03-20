<!DOCTYPE html>
<html>
<head>
    <title>Resource Library</title>
</head>
<body>
    <h1>Welcome to the Resource Library</h1>
    
    <!-- User Interface -->
    <div>
        <h2>Upload Resource</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="resource_file">
            <input type="submit" name="upload" value="Upload">
        </form>
    </div>

    <?php
    // Model
    class Resource {
        public static function upload($file) {
            $target_dir = "uploads/";
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
        if ($_FILES['resource_file']['error'] == UPLOAD_ERR_OK) {
            $uploaded_file = Resource::upload($_FILES['resource_file']);
            if ($uploaded_file) {
                echo "<p>File uploaded successfully: <a href='$uploaded_file'>" . basename($uploaded_file) . "</a></p>";
            } else {
                echo "<p>Sorry, there was an error uploading your file.</p>";
            }
        }
    }
    ?>

    <!-- Session -->
    <?php
    session_start();
    $_SESSION['last_visit'] = date('Y-m-d H:i:s');
    echo "<p>Your last visit: " . $_SESSION['last_visit'] . "</p>";
    ?>

    <!-- Cookie -->
    <?php
    $cookie_name = "user";
    $cookie_value = "Ahnaf Tahmid";
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
        var fileInput = document.forms["uploadForm"]["resource_file"].value;
        if (fileInput == "") {
            alert("Please select a file to upload");
            return false;
        }
    }
    </script>

</body>
</html>