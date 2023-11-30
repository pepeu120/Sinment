<?php
require_once "../dao/connection.php";
require_once "../model/user.php";

class UserDAO
{

    public function insert($user)
    {
        try {
            $conn = Connection::getConnection();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("INSERT INTO User (firstname, lastname, email, password)
            VALUES (:firstname, :lastname, :email, :password)");

            $firstname = $user->getFirstname();
            $lastname = $user->getLastname();
            $email = $user->getEmail();
            $password = $user->getPassword();

            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);

            $stmt->execute();

            echo "Usúario " . $user->getFirstname() . " inserido com sucesso";
        } catch (PDOException $ex) {
            $ex->getMessage();
            throw new RuntimeException("Erro ao inserir informação no banco de dados");
        } finally {
            Connection::closeConnection($conn);
        }
    }

    public function update($user)
    {
        try {
            $conn = Connection::getConnection();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare(
                "UPDATE User
                SET (firstname = :firstname, lastname = :lastname, email = :email, password = :password)
                WHERE id = :id)"
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

            echo "Usúario " . $user->getFirstname() . " alterado com sucesso";
        } catch (PDOException $ex) {
            $ex->getMessage();
            throw new RuntimeException("Erro ao inserir informação no banco de dados");
        } finally {
            Connection::closeConnection($conn);
        }
    }

    public function delete($user)
    {

        $con = Connection::getConnection();
        $stmt = null;

        try {
            $stmt = $con->prepare("DELETE FROM CURSO WHERE id = ?");

            $stmt->bindParam(1, $user->getId());

            $stmt->execute();

            echo "Curso " . $user->getNome() . " excluído com sucesso";
        } catch (PDOException $ex) {
            $ex->getMessage();
            throw new RuntimeException("Erro ao inserir informação no banco de dados");
        } finally {
            Connection::closeConnection($con, $stmt);
        }
    }

    public function select()
    {
        $users = array();

        try {
            $conn = Connection::getConnection();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * FROM User");
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
        } catch (PDOException $ex) {
            $ex->getMessage();
        } finally {
            Connection::closeConnection($conn);
        }

        return $users;
    }
}
