<?php
class FileUpload
{
    private $targetDirectory;
    private $sizeLimit;
    private $allowedTypes;

    public function __construct($targetDirectory, $sizeLimit = 500000, $allowedTypes = ['jpg', 'png', 'jpeg'])
    {
        $this->targetDirectory = $targetDirectory;
        $this->sizeLimit = $sizeLimit;
        $this->allowedTypes = $allowedTypes;
    }

    public function upload($file)
    {
        $this->createFolder($this->targetDirectory);

        $targetFile = $this->targetDirectory . uniqid() . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            return "File is not an image.";
        }

        $targetFile = $this->targetDirectory . uniqid() . '.' . $imageFileType;

        if ($file["size"] > $this->sizeLimit) {
            return "File is too large.";
        }

        if (!in_array($imageFileType, $this->allowedTypes)) {
            return "Only " . implode(', ', $this->allowedTypes) . " files are allowed.";
        }

        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return $targetFile;
        } else {
            return "Failed to upload file.";
        }
    }

    private function createFolder($targetDirectory)
    {
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }
    }
}
