<?php
require_once 'models/Model.php';

class Challenge extends Model
{
    public $id;
    public $userId;
    public $username;
    public $title;
    public $link;
    public $description;
    public $suggest;
    public $status;
    public $createdAt;

    public function getById($id) {
        $obj_select = $this->connection->prepare("SELECT * FROM challenge WHERE id = $id");
        $obj_select->execute();
        return $obj_select->fetch(PDO::FETCH_ASSOC);
    }

    public function insert()
    {
        $sql_insert = "INSERT INTO challenge (userId, username, title, link, description, suggest, status, createdAt) 
        VALUES (:userId, :username, :title, :link, :description, :suggest, :status, :createdAt)";
        $obj_insert = $this->connection->prepare($sql_insert);
        $arr_insert = [
            ':userId' => $this->userId,
            ':username' => $this->username,
            ':title' => $this->title,
            ':link' => $this->link,
            ':description' => $this->description,
            ':suggest' => $this->suggest,
            ':status' => $this->status,
            ':createdAt' => $this->createdAt
        ];
        return $obj_insert->execute($arr_insert);
    }

    public function getAll() {
        $obj_select = $this->connection->prepare("SELECT * FROM challenge ORDER BY id ASC");
        $obj_select->execute();
        $users = $obj_select->fetchAll(PDO::FETCH_ASSOC);

        return $users;
    }

    public function delete($id)
    {
        $obj_delete = $this->connection->prepare("DELETE FROM challenge WHERE id = $id");
        return $obj_delete->execute();
    }
}