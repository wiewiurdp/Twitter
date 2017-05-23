<?php

/**
 * Created by PhpStorm.
 * Message: mateusz
 * Date: 11.05.17
 * Time: 00:46
 */
class Message
{
    private $id;
    private $senderId;
    private $receiverId;
    private $topic;
    private $text;
    private $creationDate;
    private $readCheck;

    public function __construct()
    {
        $this->id = -1;
    }

    /**
     * @return int
     */
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
    public function getSenderId()
    {
        return $this->senderId;
    }

    /**
     * @param mixed $senderId
     */
    public function setSenderId($senderId)
    {
        $this->senderId = $senderId;
    }

    /**
     * @return mixed
     */
    public function getReceiverId()
    {
        return $this->receiverId;
    }

    /**
     * @param mixed $receiverId
     */
    public function setReceiverId($receiverId)
    {
        $this->receiverId = $receiverId;
    }

    /**
     * @return mixed
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @param mixed $topic
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;
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
    public function getReadCheck()
    {
        return $this->readCheck;
    }

    /**
     * @param mixed $readCheck
     */
    public function setReadCheck($readCheck)
    {
        $this->readCheck = $readCheck;
    }


    public function save(PDO $connection)
    {
        if ($this->id == -1) {
            // przygotowanie zapytania
            $sql = "INSERT INTO Message(senderId,receiverId, topic, text, creationDate, readCheck ) VALUES (:senderId, :receiverId, :topic, :text, :creationDate, :readCheck)";

            $prepare = $connection->prepare($sql);
            // Wysłanie zapytania do bazy z kluczami i wartościami do podmienienia
            $result = $prepare->execute(
                [
                    'senderId' => $this->senderId,
                    'receiverId' => $this->receiverId,
                    'topic' => $this->topic,
                    'text' => $this->text,
                    'creationDate' => $this->creationDate,
                    'readCheck' => $this->readCheck,
                ]
            );

            // Pobranie ostatniego ID dodanego rekordu
            $this->id = $connection->lastInsertId();

            return (bool)$result;
        } else {
            $sql = "UPDATE Message SET senderId=:senderId, receiverId=:receiverId, topic=:topic,  text=:text, creationDate=:creationDate, readCheck=:readCheck WHERE id=:id";
            $stmt = $connection->prepare($sql);
            $result = $stmt->execute(['id' => $this->id, 'senderId' => $this->senderId, 'receiverId' => $this->receiverId, 'topic' => $this->topic, 'text' => $this->text, 'creationDate' => $this->creationDate, 'readCheck' => $this->readCheck]);
            if ($result === true) {
                return true;
            }
        }
        return false;
    }

    public function delete(PDO $connection)
    {
        if ($this->id != -1) {
            $sql = "DELETE FROM Message WHERE id=:id";
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

    static public function loadMessageById(PDO $connection, $id)
    {
        $sql = "SELECT * FROM Message WHERE id=:id";
        $stmt = $connection->prepare($sql);
        $result = $stmt->execute(['id' => $id]);

        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $loadMessage = new Message();
            $loadMessage->id = $row['id'];
            $loadMessage->senderId = $row['senderId'];
            $loadMessage->receiverId = $row['receiverId'];
            $loadMessage->topic = $row['topic'];
            $loadMessage->text = $row['text'];
            $loadMessage->creationDate = $row['creationDate'];
            $loadMessage->readCheck = $row['readCheck'];

            return $loadMessage;
        }
        return null;
    }

    static public function loadUnreadMessagesByReceiverId(PDO $connection, $receiverId)
    {
        $sql = "SELECT * FROM Message WHERE receiverId=:receiverId AND readCheck=1";
        $ret = [];
        $stmt = $connection->prepare($sql);
        $stmt->execute(['receiverId' => $receiverId]);

        if ($stmt == true && $stmt->rowCount() > 0) {
            foreach ($stmt as $row) {

                $loadMessage = new Message();
                $loadMessage->id = $row['id'];
                $loadMessage->senderId = $row['senderId'];
                $loadMessage->receiverId = $row['receiverId'];
                $loadMessage->topic = $row['topic'];
                $loadMessage->text = $row['text'];
                $loadMessage->creationDate = $row['creationDate'];
                $loadMessage->readCheck = $row['readCheck'];
                $ret[] = $loadMessage;

            }

        }
        return $ret;
    }
    static public function loadReadMessagesByReceiverId(PDO $connection, $receiverId)
    {
        $sql = "SELECT * FROM Message WHERE receiverId=:receiverId AND readCheck=0";
        $ret = [];
        $stmt = $connection->prepare($sql);
        $stmt->execute(['receiverId' => $receiverId]);

        if ($stmt == true && $stmt->rowCount() > 0) {
            foreach ($stmt as $row) {

                $loadMessage = new Message();
                $loadMessage->id = $row['id'];
                $loadMessage->senderId = $row['senderId'];
                $loadMessage->receiverId = $row['receiverId'];
                $loadMessage->topic = $row['topic'];
                $loadMessage->text = $row['text'];
                $loadMessage->creationDate = $row['creationDate'];
                $loadMessage->readCheck = $row['readCheck'];
                $ret[] = $loadMessage;

            }

        }
        return $ret;
    }
    static public function loadMessagesBySenderId(PDO $connection, $senderId)
    {
        $sql = "SELECT * FROM Message WHERE senderId=:senderId";
        $ret = [];
        $stmt = $connection->prepare($sql);
        $stmt->execute(['senderId' => $senderId]);

        if ($stmt == true && $stmt->rowCount() > 0) {
            foreach ($stmt as $row) {

                $loadMessage = new Message();
                $loadMessage->id = $row['id'];
                $loadMessage->senderId = $row['senderId'];
                $loadMessage->receiverId = $row['receiverId'];
                $loadMessage->topic = $row['topic'];
                $loadMessage->text = $row['text'];
                $loadMessage->creationDate = $row['creationDate'];
                $loadMessage->readCheck = $row['readCheck'];
                $ret[] = $loadMessage;

            }

        }
        return $ret;
    }
    static public function loadAllMessages(PDO $connection)
    {
        $sql = "SELECT * FROM Message";
        $ret = [];
        $stmt = $connection->query($sql);

        if ($stmt == true && $stmt->rowCount() > 0) {
            foreach ($stmt as $row) {

                $loadMessage = new Message();
                $loadMessage->id = $row['id'];
                $loadMessage->senderId = $row['senderId'];
                $loadMessage->receiverId = $row['receiverId'];
                $loadMessage->topic = $row['topic'];
                $loadMessage->text = $row['text'];
                $loadMessage->creationDate = $row['creationDate'];
                $loadMessage->readCheck = $row['readCheck'];
                $ret[] = $loadMessage;


            }

        }
        return $ret;
    }
}