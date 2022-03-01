<?php
require_once 'controllers/Controller.php';
require_once 'models/Test.php';
require_once 'models/Submit.php';

class TestController extends Controller
{
    public function index()
    {
        $test_model = new Test();
        $tests = $test_model->getAll();

        $this->content = $this->render('views/tests/index.php', [
            'tests' => $tests,
        ]);

        require_once 'views/layouts/main.php';
    }

    public function detail()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = 'ID không hợp lệ';
            header('Location: index.php?controller=user&action=index');
            exit();
        }
        $id = $_GET['id'];
        $test_model = new Test();
        $test = $test_model->getById($id);
        $submit_model = new Submit();
        if ($_SESSION['user']['roleId']==1){
            $submits = $submit_model->getAllById($id);
        } else {
            $submits = $submit_model->getAllById1($id,$_SESSION['user']['id']);
        }
        $this->content = $this->render('views/tests/detail.php', [
            'test' => $test,
            'submits' => $submits
        ]);
        require_once 'views/layouts/main.php';

    }

    public function create()
    {
        if ($_SESSION['user']['roleId']!=1) {
            header("Location: index.php?controller=test");
            exit();
        }
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $test_files = $_FILES['test'];
            $status = isset($_POST['status'])? $_POST['status']:1;

            if (empty($name)) {
                $this->error = 'Cần nhập tên';
            }
            else if ($test_files['error'] == 0) {
                $extension = pathinfo($test_files['name'], PATHINFO_EXTENSION);
                $extension = strtolower($extension);
            }

            $test = '';
            if (empty($this->error)) {
                if ($test_files['error'] == 0) {
                    $dir_download = __DIR__ . '/../assets/downloads';
                    if (!file_exists($dir_download)) {
                        mkdir($dir_download);
                    }
                    $test = time() . '-test-' . $test_files['name'];
                    move_uploaded_file($test_files['tmp_name'], $dir_download . '/' . $test);
                }
                $test_model = new Test();
                $test_model->nameTest = $name;
                $test_model->userId = $_SESSION['user']['id'];
                $test_model->username = $_SESSION['user']['username'];
                $test_model->links = $test;
                $test_model->status = $status;
                $test_model->createdAt = date('Y-m-d H:i:s');
                $is_insert = $test_model->insert();
                if ($is_insert) {
                    $_SESSION['success'] = 'Thêm mới thành công';
                } else {
                    $_SESSION['error'] = 'Thêm mới thất bại';
                }
                header('Location: index.php?controller=test&action=index');
                exit();
            }

        }

        $this->content = $this->render('views/tests/create.php');
        require_once 'views/layouts/main.php';
    }

    public function delete(){
        if ($_SESSION['user']['roleId']!=1) {
            header("Location: index.php?controller=test");
            exit();
        }
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = 'ID không hợp lệ';
            header('Location: index.php?controller=test&action=index');
            exit();
        }
        $id = $_GET['id'];
        $test_model = new Test();
        $test = $test_model->getById($id);
        if (!empty($test['links'])) {
            $dir_download = __DIR__ . '/../assets/downloads';
            @unlink($dir_download . '/' . $test['links']);
        }
        $submit_model = new Submit();
        $submit_model->destroy($id);
        $is_delete = $test_model->delete($id);
        if ($is_delete) {
            $_SESSION['success'] = 'Xóa thành công';
        } else {
            $_SESSION['error'] = 'Xóa thất bại';
        }
        header('Location: index.php?controller=test&action=index');
        exit();
    }

    public function download(){
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = 'ID không hợp lệ';
            header('Location: index.php?controller=test&action=index');
            exit();
        }
        $id = $_GET['id'];
        $test_model = new Test();
        $test = $test_model->getById($id);
        $filename = $test['links'];
        $dir_download = __DIR__ . '/../assets/downloads/'.$filename;
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/zip");
        header("Content-Transfer-Emcoding: binary");
        readfile($dir_download);
        header('Location: index.php?controller=test&action=index');
        exit();
    }
}