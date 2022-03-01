<?php
require_once 'models/Model.php';

class Comment extends Model
{
    public $id;
    public $userId;
    public $username;
    public $content;
    public $createdAt;
    public $updatedAt;
    public $userId1;

    public function getAllById($id) {
        $obj_select = $this->connection
            ->prepare("SELECT * FROM comments WHERE userId1 =$id ORDER BY createdAt DESC");
        $obj_select->execute();
        $comments = $obj_select->fetchAll(PDO::FETCH_ASSOC);

        return $comments;
    }

    public function delete($id)
    {
        $obj_delete = $this->connection->prepare("DELETE FROM comments WHERE id = $id");
        return $obj_delete->execute();
    }

    public function destroy($id)
    {
        $obj_delete = $this->connection->prepare("DELETE FROM comments WHERE userId1 = $id");
        return $obj_delete->execute();
    }

    public function getById($id) {
        $obj_select = $this->connection->prepare("SELECT * FROM comments WHERE id = $id");
        $obj_select->execute();
        return $obj_select->fetch(PDO::FETCH_ASSOC);
    }

    public function insert()
    {
        $sql_insert = "INSERT INTO comments(userId, username, content, createdAt,userId1) 
        VALUES (:userId, :username, :content, :createdAt,:userId1)";
        $obj_insert = $this->connection->prepare($sql_insert);
        $arr_insert = [
            ':userId' => $this->userId,
            ':username' => $this->username,
            ':content' => $this->content,
            ':createdAt' => $this->createdAt,
            ':userId1' => $this->userId1
        ];
        return $obj_insert->execute($arr_insert);
    }

    public function update($id) {
        $obj_update = $this->connection
            ->prepare("UPDATE comments SET content=:content, updatedAt=:updatedAt WHERE id = $id");
        $arr_update = [
            ':content' => $this->content,
            ':updatedAt' => $this->updatedAt
        ];
        $obj_update->execute($arr_update);

        return $obj_update->execute($arr_update);
    }
}