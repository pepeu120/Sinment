<?php
class Post
{
    private $id;
    private $userId;
    private $caption;
    private $imagePath;
    private $postingDate;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getCaption(): string
    {
        return $this->caption;
    }

    public function setCaption(string $caption): void
    {
        $this->caption = $caption;
    }

    public function getImagePath(): string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): void
    {
        $this->imagePath = $imagePath;
    }

    public function getPostingDate(): string
    {
        return $this->postingDate;
    }

    public function setPostingDate(string $postingDate): void
    {
        $this->postingDate = $postingDate;
    }
}
