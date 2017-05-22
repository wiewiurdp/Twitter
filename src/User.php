<?php

class User
{
    private $id;
    private $username;
    private $hashPassword;
    private $email;

    public function __construct()
    {
        $this->id = -1;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getHashPassword()
    {
        return $this->hashPassword;
    }

    public function setHashPassword($password)
    {
        $hashPassword = password_hash($password, PASSWORD_BCRYPT, ['COST' => 9]);
        $this->hashPassword = $hashPassword;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function save(PDO $connection)
    {
        if ($this->id == -1) {
            // przygotowanie zapytania
            $sql = "INSERT INTO User (username, email, hashPassword) VALUES (:username,:email,:hashPassword)";
            $prepare = $connection->prepare($sql);
            // Wysłanie zapytania do bazy z kluczami i wartościami do podmienienia
            $result = $prepare->execute(['username' => $this->username, 'email' => $this->email, 'hashPassword' => $this->hashPassword,]);
            // Pobranie ostatniego ID dodanego rekordu
            $this->id = $connection->lastInsertId();

            return (bool)$result;
        } else {
            $sql = "UPDATE User SET username=:username, email=:email, hashPassword=:hashPassword WHERE id=:id";
            $stmt = $connection->prepare($sql);
            $result = $stmt->execute(['id' => $this->id, 'username' => $this->username, 'email' => $this->email, 'hashPassword' => $this->hashPassword]);
            if ($result === true) {
                return true;
            }
        }
        return false;
    }

    public function delete(PDO $connection)
    {
        if ($this->id != -1) {
            $sql = "DELETE FROM User WHERE id=:id";
            $stmt = $connection->prepare($sql);
            $result = $stmt->execute(['id' => $this->id]);

            if ($result === true) {
                $this->id = -1;

                return true;
            }
            return false;
        }
        return true;
    }

    static public function hashPassword($password)
    {
        $hashPassword = password_hash($password, PASSWORD_BCRYPT, ['COST' => 9]);
        return $hashPassword;
    }

    static public function loadUserById(PDO $connection, $id)
    {
        $sql = "SELECT * FROM User WHERE id=:id";
        $stmt = $connection->prepare($sql);
        $result = $stmt->execute(['id' => $id]);

        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $loadUser = new User();
            $loadUser->id = $row['id'];
            $loadUser->username = $row['username'];
            $loadUser->hashPassword = $row['hashPassword'];
            $loadUser->email = $row['email'];

            return $loadUser;
        }
        return null;
    }

    static public function showUserByEmail(PDO $connection, $email)
    {
        $stmt = $connection->prepare('SELECT * FROM User WHERE email=:email');
        $result = $stmt->execute(['email' => $email]);

        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->username = $row['username'];
            $loadedUser->hashPassword = $row['hashPassword'];
            $loadedUser->email = $row['email'];
            return $loadedUser;
        }

        return null;
    }
    static public function loadAllUser(PDO $connection)
    {
        $sql = "SELECT * FROM User";
        $ret = [];
        $result = $connection->query($sql);

        if ($result == true && $result->rowCount() != 0) {
            foreach ($result as $row) {

                $loadUser = new User();
                $loadUser->id = $row['id'];
                $loadUser->username = $row['username'];
                $loadUser->hashPassword = $row['hashPassword'];
                $loadUser->email = $row['email'];
                $ret[] = $loadUser;

            }

        }
        return $ret;
    }

}

