<?php

class Comment
{
    private $id;
    private $tweetId;
    private $text;
    private $creationDate;
    private $userId;

    public function __construct()
    {
        $this->id = -1;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTweetId()
    {
        return $this->tweetId;
    }

    /**
     * @param mixed $tweetId
     */
    public function setTweetId($tweetId)
    {
        $this->tweetId = $tweetId;
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


    public function save(PDO $connection)
    {
        if ($this->id == -1) {
            // przygotowanie zapytania
            $sql = "INSERT INTO Comment(tweetId, creationDate, text, userId) VALUES (:tweetId, :creationDate, :text, :userId)";

            $prepare = $connection->prepare($sql);
            // Wysłanie zapytania do bazy z kluczami i wartościami do podmienienia
            $result = $prepare->execute(
                [
                    'tweetId' => $this->tweetId,
                    'creationDate' => $this->creationDate,
                    'text' => $this->text,
                    'userId' => $this->userId,
                ]
            );

            // Pobranie ostatniego ID dodanego rekordu
            $this->id = $connection->lastInsertId();

            return (bool)$result;
        } else {
            $sql = "UPDATE Comment SET tweetId=:tweetId, creationDate=:creationDate, text=:text, userId=:userId WHERE id=:id";
            $stmt = $connection->prepare($sql);
            $result = $stmt->execute(
                [
                    'id' => $this->id,
                    'tweetId' => $this->tweetId,
                    'creationDate' => $this->creationDate,
                    'text' => $this->text,
                    'userId' => $this->userId
                ]
            );
            if ($result === true) {
                return true;
            }
        }
        return false;
    }

    public function delete(PDO $connection)
    {
        if ($this->id != -1) {
            $sql = "DELETE FROM Comment WHERE id=:id";
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

    static public function loadCommentById(PDO $connection, $id)
    {
        $sql = "SELECT * FROM Comment WHERE id=:id";
        $stmt = $connection->prepare($sql);
        $result = $stmt->execute(['id' => $id]);

        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $loadComment = new Comment();
            $loadComment->id = $row['id'];
            $loadComment->tweetId = $row['tweetId'];
            $loadComment->text = $row['text'];
            $loadComment->creationDate = $row['creationDate'];
            $loadComment->userId = $row['userId'];

            return $loadComment;
        }
        return null;
    }

    static public function loadAllCommentsByTweetId(PDO $connection, $tweetId)
    {
        $sql = "SELECT * FROM Comment WHERE tweetId=:tweetId";
        $ret = [];
        $stmt = $connection->prepare($sql);
        $stmt->execute(['tweetId' => $tweetId]);

        if ($stmt == true && $stmt->rowCount() > 0) {
            foreach ($stmt as $row) {

                $loadComment = new Comment();
                $loadComment->id = $row['id'];
                $loadComment->tweetId = $row['tweetId'];
                $loadComment->text = $row['text'];
                $loadComment->creationDate = $row['creationDate'];
                $loadComment->userId = $row['userId'];
                $ret[] = $loadComment;
            }
        }
        return $ret;
    }
}

