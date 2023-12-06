<?php
require_once __DIR__ . "/../dao/postDAO.php";
require_once __DIR__ . "/../model/post.php";
require_once "auth.php";

if (!Auth::isLoggedIn()) {
    header("Location: /Sinment/index.php");
    exit();
}

$user = $_SESSION['user'];
$targetDirectory = "../../uploads/";

if (!file_exists($targetDirectory)) {
    mkdir($targetDirectory, 0777, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitPost"])) {
    $postCaption = htmlspecialchars($_POST["postCaption"]);

    $targetFile = $targetDirectory . basename($_FILES["postImage"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["postImage"]["tmp_name"]);
    if ($check === false) {
        throw new Exception("The file is not an image.");
    }

    $targetFile = $targetDirectory . uniqid() . '.' . $imageFileType;

    if ($_FILES["postImage"]["size"] > 5000000) {
        throw new Exception("The file is too large.");
    }

    $allowedFormats = ["jpg", "jpeg", "png"];
    if (!in_array($imageFileType, $allowedFormats)) {
        throw new Exception("Only JPG, JPEG, and PNG files are allowed.");
    }

    if (move_uploaded_file($_FILES["postImage"]["tmp_name"], $targetFile)) {
        echo "The file " . htmlspecialchars(basename($_FILES["postImage"]["name"])) . " has been uploaded.";

        $post = new Post();
        $post->setUserId($user->getId());
        $post->setCaption($postCaption);
        $post->setimagePath($targetFile);

        $postDAO = new PostDAO();

        if ($postDAO->insert($post)) {
            echo "Post has been saved in the database.";
        } else {
            throw new Exception("There was an error saving the post in the database.");
        }
    } else {
        throw new Exception("Sorry, there was an error uploading your file.");
    }
}
