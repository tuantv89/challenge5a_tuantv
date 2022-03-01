<?php
require_once 'controllers/Controller.php';
require_once 'models/Challenge.php';

class ChallengeController extends Controller
{
    public function index()
    {
        $challenge_model = new Challenge();
        $challenges = $challenge_model->getAll();

        $this->content = $this->render('views/challenges/index.php', [
            'challenges' => $challenges,
        ]);

        require_once 'views/layouts/main.php';
    }

    public function answer()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = 'ID không hợp lệ';
            header('Location: index.php?controller=challenge&action=index');
            exit();
        }
        $id = $_GET['id'];
        $challenge_model = new Challenge();
        $challenge = $challenge_model->getById($id);
        $result = "";
        $check=false;
        if (isset($_POST['submit'])) {
            $answer = $_POST['answer'].".txt";
            if($challenge['link']==$answer || $challenge['link']==$_POST['answer']){
                $dir_download = __DIR__ . '/../assets/challenges';
                $myfile = fopen($dir_download. '/' . $challenge['link'],'r');
                $result = fread($myfile, filesize($dir_download. '/' . $challenge['link']));
            }
            $check=true;
        }

        $this->content = $this->render('views/challenges/answer.php', [
            'challenge' => $challenge,
            'result' => $result,
            'check' => $check
        ]);

        require_once 'views/layouts/main.php';
    }

    public function create()
    {
        if ($_SESSION['user']['roleId']!=1) {
            header("Location: index.php?controller=challenge");
            exit();
        }
        if (isset($_POST['submit'])) {
            $suggest = $_POST['suggest'];
            $title = $_POST['title'];
            $challenge_files = $_FILES['challenge'];
            $status = isset($_POST['status'])? $_POST['status']:1;

            if (empty($suggest)){
                $this->error = 'Cần nhập Gợi ý';
            } else if ($challenge_files['error'] == 0) {
                $extension_arr = ['txt'];
                $extension = pathinfo($challenge_files['name'], PATHINFO_EXTENSION);
                $extension = strtolower($extension);
                if (!in_array($extension, $extension_arr)) {
                    $this->error = 'File cần là .txt';
                } elseif ($challenge_files['size']==0){
                    $this->error = 'Không được là File rỗng';
                }
            }
            if (empty($this->error)) {
                if ($challenge_files['error'] == 0) {
                    $dir_download = __DIR__ . '/../assets/challenges';
                    if (!file_exists($dir_download)) {
                        mkdir($dir_download);
                    }
                    move_uploaded_file($challenge_files['tmp_name'], $dir_download . '/' . $challenge_files['name']);
//                    rename($dir_download . '/' . $challenge_files['name'],$dir_download . '/' . $challenge_files['name']);
                }
                $challenge_model = new Challenge();
                $challenge_model->userId = $_SESSION['user']['id'];
                $challenge_model->username = $_SESSION['user']['username'];
                $challenge_model->title = $title;
                $challenge_model->link = $challenge_files['name'];
                $challenge_model->description = "";
                $challenge_model->status = 1;
                $challenge_model->suggest = $suggest;
                $challenge_model->createdAt = date('Y-m-d H:i:s');
                $is_insert = $challenge_model->insert();
                if ($is_insert) {
                    $_SESSION['success'] = 'Thêm mới thành công';
                } else {
                    $_SESSION['error'] = 'Thêm mới thất bại';
                }
                header('Location: index.php?controller=challenge&action=index');
                exit();
            }

        }

        $this->content = $this->render('views/challenges/create.php');
        require_once 'views/layouts/main.php';
    }

    public function delete(){
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = 'ID không hợp lệ';
            header('Location: index.php?controller=challenge');
            exit();
        }
        $id = $_GET['id'];
        $challenge_model = new Challenge();
        $challenge = $challenge_model->getById($id);
        if ($_SESSION['user']['id']!=$challenge['userId']){
            $_SESSION['error'] = 'Không thể xóa bài của người khác';
            header('Location: index.php?controller=challenge');
            exit();
        }
        if (!empty($challenge['link'])) {
            $dir_challenge = __DIR__ . '/../assets/challenges';
            @unlink($dir_challenge . '/' . $challenge['link']);
        }
        $is_delete = $challenge_model->delete($id);
        if ($is_delete) {
            $_SESSION['success'] = 'Xóa thành công';
        } else {
            $_SESSION['error'] = 'Xóa thất bại';
        }
        header('Location: index.php?controller=challenge');
        exit();
    }
}