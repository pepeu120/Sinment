<?php

class FileUpload
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload($file)
    {
        $targetFile = $this->targetDirectory . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File is not an image.");
        }

        // Check file size
        if ($file["size"] > 500000) {
            throw new Exception("File is too large.");
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            throw new Exception("Only JPG, JPEG, PNG & GIF files are allowed.");
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            throw new Exception("File already exists.");
        }

        // Try to upload file
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return $targetFile;
        } else {
            throw new Exception("Failed to upload file.");
        }
    }
}
