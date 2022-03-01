<?php
require_once 'models/Model.php';

class User extends Model {
    public $id;
    public $username;
    public $password;
    public $roleId;
    public $owenrId;
    public $fullName;
    public $email;
    public $phone;
    public $avatar;
    public $url;
    public $status;
    public $createdAt;
    public $updatedAt;

    public $str_search;

    public function __construct() {
        parent::__construct();
        if (isset($_GET['username']) && !empty($_GET['username'])) {
            $username = addslashes($_GET['username']);
            $this->str_search .= " AND users.username LIKE '%$username%'";
        }
    }

    public function getAll() {
        $obj_select = $this->connection
            ->prepare("SELECT * FROM users ORDER BY id ASC");
        $obj_select->execute();
        $users = $obj_select->fetchAll(PDO::FETCH_ASSOC);

        return $users;
    }

    public function isUsernameExists($username) {
        $sql_select_one = "SELECT * FROM users WHERE username=:username";
        $obj_select_one = $this->connection->prepare($sql_select_one);
        $arr_select = [
            ':username' => $username
        ];
        $obj_select_one->execute($arr_select);
        $user = $obj_select_one->fetch(PDO::FETCH_ASSOC);
        if (!empty($user)) {
            return TRUE;
        }
        return FALSE;
    }

    public function register($username, $password,$owenrId,$fullName,$email,$phone,$avatar,$status) {
        $sql_insert = "INSERT INTO users(username, password, roleId,owenrId,fullName,email,phone,avatar,status) 
        VALUES (:username, :password, :roleId, :owenrId, :fullName, :email, :phone, :avatar, :status)";
        $obj_insert = $this->connection->prepare($sql_insert);
        $arr_insert = [
            ':username' => $username,
            ':password' => $password,
            ':roleId' => 2,
            ':owenrId' => $owenrId,
            ':fullName' => $fullName,
            ':email' => $email,
            ':phone' => $phone,
            ':avatar' => $avatar,
            ':status' => $status
        ];
        $is_insert = $obj_insert->execute($arr_insert);
        return $is_insert;
    }


    public function getById($id) {
        $obj_select = $this->connection
            ->prepare("SELECT * FROM users WHERE id = $id");
        $obj_select->execute();
        return $obj_select->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllPagination($params = []) {
        $limit = $params['limit'];
        $page = $params['page'];
        $start = ($page - 1) * $limit;
        $obj_select = $this->connection
            ->prepare("SELECT * FROM users WHERE TRUE $this->str_search
              ORDER BY created_at DESC
              LIMIT $start, $limit");

        $obj_select->execute();
        $users = $obj_select->fetchAll(PDO::FETCH_ASSOC);

        return $users;
    }

    public function getUserByUsername($username) {
        $obj_select = $this->connection
            ->prepare("SELECT COUNT(id) FROM users WHERE username='$username'");
        $obj_select->execute();
        return $obj_select->fetchColumn();
    }

    public function update($id) {
        $obj_update = $this->connection
            ->prepare("UPDATE users SET username=:username, password=:password, fullName=:fullName, email=:email, phone=:phone, 
                 avatar=:avatar, status=:status, updatedAt=:updatedAt
             WHERE id = $id");
        $arr_update = [
            ':username' => $this->username,
            ':password' => $this->password,
            ':fullName' => $this->fullName,
            ':email' => $this->email,
            ':phone' => $this->phone,
            ':avatar' => $this->avatar,
            ':status' => $this->status,
            ':updatedAt' => $this->updatedAt,
        ];
        $obj_update->execute($arr_update);

        return $obj_update->execute($arr_update);
    }

    public function updateV2($id) {
        $obj_update = $this->connection
            ->prepare("UPDATE users SET avatar=:avatar, url=:url, updatedAt=:updatedAt WHERE id = $id");
        $arr_update = [
            ':avatar' => $this->avatar,
            ':url' => $this->url,
            ':updatedAt' => $this->updatedAt,
        ];
        $obj_update->execute($arr_update);

        return $obj_update->execute($arr_update);
    }

    public function delete($id)
    {
        $obj_delete = $this->connection
            ->prepare("DELETE FROM users WHERE id = $id");
        return $obj_delete->execute();
    }

    public function getUserByUsernameAndPassword($username, $password) {
        $obj_select = $this->connection
            ->prepare("SELECT * FROM users WHERE username=:username AND password=:password LIMIT 1");
        $arr_select = [
            ':username' => $username,
            ':password' => $password,
        ];
        $obj_select->execute($arr_select);

        $user = $obj_select->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

    public function getUser($username, $password) {
        $sql_select_one = "SELECT * FROM users WHERE username=:username AND password=:password";
        $obj_select_one = $this->connection->prepare($sql_select_one);
        $arr_select = [
            ':username' => $username,
            ':password' => $password
        ];
        $obj_select_one->execute($arr_select);
        $user = $obj_select_one->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
}