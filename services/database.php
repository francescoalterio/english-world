<?php

class Database
{
    private $connection;

    function __construct()
    {
        require_once("./database.config.php");
        $this->connection = new PDO($host, $user, $password, $options);
    }

    function getUserByField(string $field, string $userID)
    {
        $sql = $this->connection->prepare("SELECT * FROM users WHERE $field = :id");
        $sql->execute(['id' => $userID]);
        $result = $sql->fetch();
        return $result;
    }

    function createUser(string $username, string $email, string $password)
    {
        require_once("./utils/generateUUID.php");
        $newID = "";
        while (!$newID) {
            $id = generateUUID();
            $existingUser = $this->getUserByField("id", $id);
            if (!$existingUser) {
                $newID = $id;
                break;
            }
        }

        try {
            $existingUser = $this->getUserByField("email", $email);
            if (!$existingUser) {
                $sql = $this->connection->prepare("INSERT INTO users (id, username, email,password) VALUES (:id, :username, :email, :password)");
                $sql->execute(['id' => $newID, "username" => $username, "email" => $email, "password" => password_hash($password, PASSWORD_BCRYPT)]);
                $sql->fetch();
                return ["status" => "success", "userID" => $newID];
            } else {
                return ["status" => "error", "message" => "The email is already in use."];
            }
        } catch (PDOException $e) {
            return ["status" => "error", "message" => "The user could not be created, try again."];
        }
    }

    function getUserByEmailAndPassword(string $email, string $password)
    {
        try {
            $sql = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
            $sql->execute(["email" => $email]);
            $userData = $sql->fetch();

            if ($userData && password_verify($password, $userData['password'])) {
                return ["status" => "success", "userData" => ["id" => $userData['id'], "username" => $userData['username'], "email" => $userData['email']]];
            } else {
                return ["status" => "error", "message" => "The username or password is not correct."];
            }
        } catch (PDOException $e) {
            return ["status" => "error", "message" => "The action could not be performed, try again."];
        }
    }
}
