<?php
require_once 'controllers/Controller.php';
require_once 'models/Comment.php';

class CommentController extends Controller
{
    public function delete(){
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = 'ID không hợp lệ';
            header('Location: index.php?controller=user&action=detail&id='.$_GET['back']);
            exit();
        }
        $id = $_GET['id'];
        $comment_model = new Comment();
        $is_delete = $comment_model->delete($id);
        if ($is_delete) {
            $_SESSION['success'] = 'Xóa thành công';
        } else {
            $_SESSION['error'] = 'Xóa thất bại';
        }
        header('Location: index.php?controller=user&action=detail&id='.$_GET['back']);
        exit();
    }

    public function create(){
        if (isset($_POST['submit'])){
            $content = $_POST['content'];
            $comment_model = new Comment();
            $comment_model->userId = $_SESSION['user']['id'];
            $comment_model->username = $_SESSION['user']['username'];
            $comment_model->content = $content;
            $comment_model->createdAt = date('Y-m-d H:i:s');
            $comment_model->userId1 = $_GET['back'];
            $is_insert = $comment_model->insert();
            if ($is_insert) {
                $_SESSION['success'] = 'Nhắn thành công';
            } else {
                $_SESSION['error'] = 'Nhắn thất bại';
            }
            header('Location: index.php?controller=user&action=detail&id='.$_GET['back']);
            exit();
        }
    }

    public function update(){
        if (isset($_POST['submit'])){
            $content = $_POST['content'];
            $comment_model = new Comment();
            $comment_model->content = $content;
            $comment_model->updatedAt = date('Y-m-d H:i:s');
            $is_update = $comment_model->update($_GET['id']);
            if ($is_update) {
                $_SESSION['success'] = 'Cập nhật thành công';
            } else {
                $_SESSION['error'] = 'Cập nhật thất bại';
            }
            header('Location: index.php?controller=user&action=detail&id='.$_GET['back']);
            exit();
        }
    }
}