<?php
require_once 'controllers/Controller.php';
require_once 'models/Submit.php';

class SubmitController extends Controller
{
    public function download(){
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = 'ID không hợp lệ';
            header('Location: index.php?controller=test&action=index');
            exit();
        }
        $id = $_GET['id'];
        $submit_model = new Submit();
        $submit = $submit_model->getById($id);
        $filename = $submit['link'];
        $dir_download = __DIR__ . '/../assets/submits/'.$filename;
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/zip");
        header("Content-Transfer-Emcoding: binary");
        readfile($dir_download);
        header('Location: index.php?controller=test&action=detail&id='.$submit['testId']);
        exit();
    }

    public function create(){
        if (isset($_POST['submit'])){
            $submit_files = $_FILES['link'];
            if ($submit_files['error'] == 0) {
                $extension = pathinfo($submit_files['name'], PATHINFO_EXTENSION);
                $extension = strtolower($extension);
            }
            if ($submit_files['error'] == 0) {
                $dir_download = __DIR__ . '/../assets/submits';
                if (!file_exists($dir_download)) {
                    mkdir($dir_download);
                }
                $submit = time() . '-submit-' . $submit_files['name'];
                move_uploaded_file($submit_files['tmp_name'], $dir_download . '/' . $submit);
            }
            $submit_model = new Submit();
            $submit_model->userId = $_SESSION['user']['id'];
            $submit_model->username = $_SESSION['user']['username'];
            $submit_model->testId = $_POST['testId'];
            $submit_model->testName = $_POST['testName'];
            $submit_model->link = $submit;
            $submit_model->status = 1;
            $submit_model->createdAt = date('Y-m-d H:i:s');
            $is_insert = $submit_model->insert();
            if ($is_insert) {
                $_SESSION['success'] = 'Nộp bài thành công';
            } else {
                $_SESSION['error'] = 'Nộp bài thất bại';
            }
            header('Location: index.php?controller=test&action=detail&id='.$_POST['testId']);
            exit();
        }
    }
}