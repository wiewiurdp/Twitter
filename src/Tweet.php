<?php

/**
 * Created by PhpStorm.
 * User: mateusz
 * Date: 09.05.17
 * Time: 00:55
 */
class Tweet
{
    private $id;
    private $userId;
    private $text;
    private $creationDate;

    public function __construct()
    {
        $this->id = -1;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param mixed $creationDate
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function saveToDB(PDO $connection)
    {
        if ($this->id == -1) {
            // przygotowanie zapytania
            $sql = "INSERT INTO Tweet(userId, text, creationDate) VALUES (:userId, :text, :creationDate)";

            $prepare = $connection->prepare($sql);
            // Wysłanie zapytania do bazy z kluczami i wartościami do podmienienia
            $result = $prepare->execute(
                [
                    'userID' => $this->userId,
                    'text' => $this->text,
                    'creationDate' => $this->creationDate,
                ]
            );

            // Pobranie ostatniego ID dodanego rekordu
            $this->id = $connection->lastInsertId();

            return (bool)$result;
        } else {
            $sql = "UPDATE Tweet SET userId=:userId, text=:text, creationDate=:creationDate WHERE id=:id";
            $stmt = $connection->prepare($sql);
            $result = $stmt->execute(['id' => $this->id, 'userId' => $this->userId, 'text' => $this->text, 'creationDate' => $this->creationDate]);
            if ($result === true) {
                return true;
            }
        }
        return false;
    }


    public function delete(PDO $connection)
    {
        if ($this->id != -1) {
            $sql = "DELETE FROM Tweet WHERE id=:id";
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
    static public function loadTweetById(PDO $connection, $id)
    {
        $sql = "SELECT * FROM Tweet WHERE id=:id";
        $stmt = $connection->prepare($sql);
        $result = $stmt->execute(['id' => $id]);

        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $loadTweet = new Tweet();
            $loadTweet->id = $row['id'];
            $loadTweet->userId = $row['userId'];
            $loadTweet->text = $row['text'];
            $loadTweet->creationDate = $row['creationDate'];

            return $loadTweet;
        }
        return null;
    }

    static public function showAllTweetsByUserId(PDO $connection, $userId)
    {
        $sql = "SELECT * FROM Tweet WHERE userId=:userId";
        $ret = [];
        $stmt = $connection->prepare($sql);
        $stmt->execute(['userId' => $userId]);

        if ($stmt == true && $stmt->rowCount() > 0) {
            foreach ($stmt as $row) {

                $loadTweet = new Tweet();
                $loadTweet->id = $row['id'];
                $loadTweet->userId = $row['userId'];
                $loadTweet->text = $row['text'];
                $loadTweet->creationDate = $row['creationDate'];
                $ret[] = $loadTweet;

            }

        }
        return $ret;
    }
    static public function showAllTweets(PDO $connection)
    {
        $sql = "SELECT * FROM Tweet";
        $ret = [];
        $stmt = $connection->query($sql);

        if ($stmt == true && $stmt->rowCount() > 0) {
            foreach ($stmt as $row) {

                $loadTweet = new Tweet();
                $loadTweet->id = $row['id'];
                $loadTweet->userId = $row['userId'];
                $loadTweet->text = $row['text'];
                $loadTweet->creationDate = $row['creationDate'];
                $ret[] = $loadTweet;

            }

        }
        return $ret;
    }

}