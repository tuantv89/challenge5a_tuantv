<?php
require_once 'models/Model.php';

class Test extends Model
{
    public $id;
    public $nameTest;
    public $userId;
    public $username;
    public $links;
    public $status;
    public $createdAt;
    public $updatedAt;

    public function insert()
    {
        $sql_insert = "INSERT INTO tests ( nameTest, userId, username, links, status, createdAt)
            VALUES( :nameTest, :userId, :username, :links, :status, :createdAt)";
        $obj_insert = $this->connection->prepare($sql_insert);
        $arr_insert = [
            ':nameTest' => $this->nameTest,
            ':userId' => $this->userId,
            ':username' => $this->username,
            ':links' => $this->links,
            ':status' => $this->status,
            ':createdAt' => $this->createdAt
        ];
        return $obj_insert->execute($arr_insert);
    }

    public function getAll()
    {
        $sql_select_all = "SELECT * FROM tests";
        $obj_select_all = $this->connection->prepare($sql_select_all);
        $obj_select_all->execute();
        return $obj_select_all->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $obj_delete = $this->connection->prepare("DELETE FROM tests WHERE id = $id");
        return $obj_delete->execute();
    }

    public function getById($id) {
        $obj_select = $this->connection->prepare("SELECT * FROM tests WHERE id = $id");
        $obj_select->execute();
        return $obj_select->fetch(PDO::FETCH_ASSOC);
    }
}