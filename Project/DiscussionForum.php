<!DOCTYPE html>
<html>
<head>
    <title>Discussion Forum</title>
</head>
<body>
    <h1>Welcome to the Discussion Forum</h1>
    
    <!-- User Interface -->
    <div>
        <h2>Create a new post</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <label for="post_title">Title:</label><br>
            <input type="text" id="post_title" name="post_title"><br>
            <label for="post_content">Content:</label><br>
            <textarea id="post_content" name="post_content" rows="4" cols="50"></textarea><br>
            <input type="file" name="post_attachment">
            <input type="submit" name="submit_post" value="Submit">
        </form>
    </div>

    <?php
    // Model
    class Post {
        public static function create($title, $content, $attachment) {
            // Save post to database or file system
            // Here, we will just display the post data
            echo "<h2>New Post:</h2>";
            echo "<p>Title: $title</p>";
            echo "<p>Content: $content</p>";
            if ($attachment) {
                echo "<p>Attachment: <a href='$attachment'>" . basename($attachment) . "</a></p>";
            }
        }
    }

    // Controller
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_post'])) {
        $title = $_POST['post_title'];
        $content = $_POST['post_content'];
        $attachment = $_FILES['post_attachment'];

        if (empty($title) || empty($content)) {
            echo "<p>Please fill in all fields.</p>";
        } else {
            Post::create($title, $content, $attachment['tmp_name']);
            // Upload attachment
            if ($attachment['error'] == UPLOAD_ERR_OK) {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($attachment["name"]);
                if (move_uploaded_file($attachment["tmp_name"], $target_file)) {
                    echo "<p>Attachment uploaded successfully.</p>";
                } else {
                    echo "<p>Sorry, there was an error uploading your attachment.</p>";
                }
            }
        }
    }
    ?>

    <!-- Session -->
    <?php
    session_start();
    if (!isset($_SESSION['user'])) {
        $_SESSION['user'] = "Guest";
    }
    echo "<p>Welcome, " . $_SESSION['user'] . "!</p>";
    ?>

    <!-- Cookie -->
    <?php
    $cookie_name = "user";
    $cookie_value = "Ahnaf Tahmid";
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
    if (!isset($_COOKIE[$cookie_name])) {
        echo "<p>Cookie named '" . $cookie_name . "' is not set!</p>";
    } else {
        echo "<p>Cookie '" . $cookie_name . "' is set!</p>";
        echo "<p>Welcome " . $_COOKIE[$cookie_name] . "!</p>";
    }
    ?>

    <!-- Form Validation -->
    <script>
    function validateForm() {
        var title = document.getElementById("post_title").value;
        var content = document.getElementById("post_content").value;
        if (title.trim() == "" || content.trim() == "") {
            alert("Please fill in all fields.");
            return false;
        }
    }
    </script>

</body>
</html>
