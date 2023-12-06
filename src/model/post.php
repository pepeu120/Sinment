<?php
class Post
{
    private $id;
    private $userId;
    private $caption;
    private $imagePath;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id= $id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getCaption()
    {
        return $this->caption;
    }

    public function setCaption($caption)
    {
        $this->caption = $caption;
    }

    public function getImagePath()
    {
        return $this->imagePath;
    }

    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    }

}
