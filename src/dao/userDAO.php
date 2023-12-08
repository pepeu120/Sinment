<?php
require_once __DIR__ . "/../model/user.php";

class UserDAO
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function emailExists($email): bool
    {
        $stmt = $this->conn->prepare("SELECT 1 FROM User WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function insert(User $user): bool
    {
        $stmt = $this->conn->prepare("INSERT INTO User (firstname, lastname, email, password)
        VALUES (:firstname, :lastname, :email, :password)");

        $firstname = $user->getFirstname();
        $lastname = $user->getLastname();
        $email = $user->getEmail();
        $password = $user->getPassword();

        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);


        return $stmt->execute();
    }

    public function update($user): bool
    {
        $stmt = $this->conn->prepare(
            "UPDATE User
                SET firstname = :firstname, lastname = :lastname, email = :email, password = :password
                WHERE id = :id"
        );

        $firstname = $user->getFirstname();
        $lastname = $user->getLastname();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $id = $user->getId();

        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return true;
    }

    public function delete($user): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM CURSO WHERE id = ?");
        $stmt->bindParam(1, $user->getId());
        $stmt->execute();


        return true;
    }

    public function select(): array
    {
        $users = array();

        $stmt = $this->conn->prepare("SELECT * FROM User");
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new User();
            $user->setId($row['id']);
            $user->setFirstname($row['firstname']);
            $user->setLastname($row['lastname']);
            $user->setEmail($row['email']);
            $user->setPassword($row['password']);
            $users[] = $user;
        }


        return $users;
    }

    public function getUserById($id): ?User
    {
        $stmt = $this->conn->prepare("SELECT * FROM User WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new User();
            $user->setId($row['id']);
            $user->setFirstname($row['firstname']);
            $user->setLastname($row['lastname']);
            $user->setEmail($row['email']);
            $user->setPassword($row['password']);

            return $user;
        } else {
            return null;
        }
    }

    public function authenticate($email): ?User
    {
        $stmt = $this->conn->prepare("SELECT * FROM User WHERE email = ?");
        $stmt->bindParam(1, $email);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new User();
            $user->setId($row['id']);
            $user->setFirstname($row['firstname']);
            $user->setLastname($row['lastname']);
            $user->setEmail($row['email']);
            $user->setPassword($row['password']);

            return $user;

        } else {
            return null;
        }
    }

    public function getUserByEmail($email): ?User
    {
        $stmt = $this->conn->prepare("SELECT * FROM User WHERE email = ?");
        $stmt->bindValue(1, $email);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new User();
            $user->setId($row['id']);
            $user->setFirstname($row['firstname']);
            $user->setLastname($row['lastname']);
            $user->setEmail($row['email']);
            $user->setPassword($row['password']);

            return $user;
        } else {
            return null;
        }
    }
}
