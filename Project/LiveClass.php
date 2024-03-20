<!DOCTYPE html>
<html>
<head>
    <title>Live Classes</title>
</head>
<body>
    <h1>Welcome to Live Classes</h1>
    
    <!-- User Interface -->
    <div>
        <h2>Upload Class Material</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="class_material">
            <input type="submit" name="upload" value="Upload">
        </form>
    </div>

    <?php
    // Model
    class ClassMaterial {
        public static function upload($file) {
            $target_dir = "materials/";
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
        if ($_FILES['class_material']['error'] == UPLOAD_ERR_OK) {
            $uploaded_file = ClassMaterial::upload($_FILES['class_material']);
            if ($uploaded_file) {
                echo "<p>Material uploaded successfully: <a href='$uploaded_file'>" . basename($uploaded_file) . "</a></p>";
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
        var fileInput = document.forms["uploadForm"]["class_material"].value;
        if (fileInput == "") {
            alert("Please select a file to upload");
            return false;
        }
    }
    </script>

</body>
</html>
