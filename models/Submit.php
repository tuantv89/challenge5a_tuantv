<?php
require_once 'models/Model.php';

class Submit extends Model
{
    public $id;
    public $userId;
    public $username;
    public $testId;
    public $testName;
    public $link;
    public $status;
    public $createdAt;
    public $updatedAt;

    public function getAllById($id) {
        $obj_select = $this->connection
            ->prepare("SELECT * FROM submit WHERE testId = $id ORDER BY createdAt DESC");
        $obj_select->execute();
        $tests = $obj_select->fetchAll(PDO::FETCH_ASSOC);
        return $tests;
    }

    public function getAllById1($id, $userId) {
        $obj_select = $this->connection->prepare("SELECT * FROM submit WHERE testId = $id AND userId = $userId ORDER BY createdAt DESC");
        $obj_select->execute();
        return $obj_select->fetchAll(PDO::FETCH_ASSOC);
    }

    public function destroy($id)
    {
        $obj_delete = $this->connection->prepare("DELETE FROM submit WHERE testId = $id");
        return $obj_delete->execute();
    }

    public function getById($id) {
        $obj_select = $this->connection->prepare("SELECT * FROM submit WHERE id = $id");
        $obj_select->execute();
        return $obj_select->fetch(PDO::FETCH_ASSOC);
    }

    public function insert()
    {
        $sql_insert = "INSERT INTO submit ( userId, username, testId, testName,link, status, createdAt)
            VALUES( :userId, :username, :testId, :testName,:link, :status, :createdAt)";
        $obj_insert = $this->connection->prepare($sql_insert);
        $arr_insert = [
            ':userId' => $this->userId,
            ':username' => $this->username,
            ':testId' => $this->testId,
            ':testName' => $this->testName,
            ':link' => $this->link,
            ':status' => $this->status,
            ':createdAt' => $this->createdAt
        ];
        return $obj_insert->execute($arr_insert);
    }
}