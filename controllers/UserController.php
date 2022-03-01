<?php
require_once 'controllers/Controller.php';
require_once 'models/User.php';
require_once 'models/Comment.php';

class UserController extends Controller {

    public function detail()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = 'ID không hợp lệ';
            header('Location: index.php?controller=user&action=index');
            exit();
        }
        $id = $_GET['id'];
        $user_model = new User();
        $user = $user_model->getById($id);
        $comment_model = new Comment();
        $comments = $comment_model->getAllById($id);
        $comment_get = "";
        if(!empty($_GET['comment'])){
            $comment_get = $comment_model->getById($_GET['comment']);
        }
        $owenr = $user_model->getById($user['owenrId']);
        $this->content = $this->render('views/users/detail.php', [
            'user' => $user,
            'owenr' => $owenr,
            'comments' => $comments,
            'comment_get' => $comment_get
        ]);
        require_once 'views/layouts/main.php';
    }

    public function logout(){
        unset($_SESSION['user']);
        $_SESSION['success']="Đăng xuất thành công";
        header("location:index.php?controller=user&action=login");
        exit();
    }

    public function delete(){
        if ($_SESSION['user']['roleId']!=1) {
            header("Location: index.php?controller=user");
            exit();
        }
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = 'ID không hợp lệ';
            header('Location: index.php?controller=user&action=index');
            exit();
        }
        $id = $_GET['id'];
        if ($_SESSION['user']['id']==$id) {
            header("Location: index.php?controller=user");
            exit();
        }
        $user_model = new User();
        $user = $user_model->getById($id);
        $comment_model = new Comment();
        $comment_model->destroy($id);
        $is_delete = $user_model->delete($id);
        if (!empty($user['avatar'])) {
            $dir_uploads = __DIR__ . '/../assets/uploads';
            @unlink($dir_uploads . '/' . $user['avatar']);
        }
        if ($is_delete) {
            $_SESSION['success'] = 'Xóa thành công';
        } else {
            $_SESSION['error'] = 'Xóa thất bại';
        }
        header('Location: index.php?controller=user&action=index');
        exit();
    }

    public function index() {
        if (!isset($_SESSION['user']['username'])){
            header("location:index.php?controller=user&action=login");
            exit();
        }
        $userModel = new User();
        $users = $userModel->getAll();

        $this->content = $this->render('views/users/index.php', [
            'users' => $users
        ]);
        require_once 'views/layouts/main.php';
    }

    public function update() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            header("Location: index.php?controller=user");
            exit();
        }
        $id = $_GET['id'];
        if ($_SESSION['user']['roleId']!=1 && $_SESSION['user']['id']!=$id) {
            header("Location: index.php?controller=user");
            exit();
        }
        $user_model = new User();
        $user = $user_model->getById($id);
        if (isset($_POST['update'])) {
            $password = $_POST['password'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $status = $_POST['status'];
            if ($_FILES['avatar']['error'] == 0) {
                $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                $extension = strtolower($extension);
                $allow_extensions = ['png', 'jpg', 'jpeg', 'gif'];
                $file_size_mb = $_FILES['avatar']['size'] / 1024 / 1024;
                $file_size_mb = round($file_size_mb, 5);
                if (!in_array($extension, $allow_extensions)) {
                    $this->error = 'Phải upload avatar dạng ảnh';
                } else if ($file_size_mb > 5) {
                    $this->error = 'File upload không được lớn hơn 5Mb';
                }
            }

            if (empty($this->error)) {
                $filename = $user['avatar'];
                if ($_FILES['avatar']['error'] == 0) {
                    $dir_uploads = __DIR__ . '/../assets/uploads';
                    @unlink($dir_uploads . '/' . $filename);
                    if (!file_exists($dir_uploads)) {
                        mkdir($dir_uploads);
                    }

                    $filename = time() . '-user-' . $_FILES['avatar']['name'];
                    move_uploaded_file($_FILES['avatar']['tmp_name'], $dir_uploads . '/' . $filename);
                    if ($_SESSION['user']['username']==$user['username']){
                        unset($_SESSION['user']['avatar']);
                        $_SESSION['user']['avatar']=$filename;
                    }
                }
                $user_model->username = empty($_POST['username']) ? $user["username"]: $_POST['username'];
                $user_model->password = empty($password) ? $user['password']: md5($password);
                $user_model->fullName = empty($_POST['fullName']) ? $user["fullName"]: $_POST['fullName'];
                $user_model->email = $email;
                $user_model->phone = $phone;
                $user_model->status = $status;
                $user_model->avatar = $filename;
                $user_model->updatedAt = date('Y-m-d H:i:s');
                $is_update = $user_model->update($id);
                if ($is_update) {
                    $_SESSION['success'] = 'Update dữ liệu thành công';
                } else {
                    $_SESSION['error'] = 'Update dữ liệu thất bại';
                }
                header('Location: index.php?controller=user&action=index');
                exit();
            }
        }

        $this->content = $this->render('views/users/update.php', [
            'user' => $user
        ]);

        require_once 'views/layouts/main.php';
    }

    public function updateV2() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            header("Location: index.php?controller=user");
            exit();
        }
        $id = $_GET['id'];
        if ($_SESSION['user']['roleId']!=1 && $_SESSION['user']['id']!=$id) {
            header("Location: index.php?controller=user");
            exit();
        }
        $user_model = new User();
        $user = $user_model->getById($id);
        if (isset($_POST['update'])) {
            $url = $_POST['url'];
            $image_name = $avatar = time() . '-user-'.basename($url);
            $dir_uploads = __DIR__ . '/../assets/uploads/';
            $dir_upload = $dir_uploads.$image_name;
//            $ch = curl_init($url);
//            $fp = fopen($dir_upload,'wb');
//            curl_setopt($ch, CURLOPT_FILE, $fp);
//            curl_setopt($ch, CURLOPT_HEADER, 0);
//            curl_setopt($ch, CURLOPT_HTTP_CONTENT_DECODING, false);
//            curl_exec($ch);
//            curl_close($ch);
//            fclose($fp);
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTP_CONTENT_DECODING, false);
            $source = curl_exec( $ch );
            $info = curl_getinfo($ch);
            curl_close( $ch );
            file_put_contents( $dir_upload, $source );
            if (empty($this->error)) {
                $user_model->avatar = $image_name;
                $user_model->url = $url;
                $user_model->updatedAt = date('Y-m-d H:i:s');
                move_uploaded_file($dir_uploads.$user['avatar'], $dir_uploads . $image_name);
                if (!file_exists($dir_uploads. $image_name)) {
                    $_SESSION['error'] = 'Lấy ảnh thất bại';
                    header('Location: index.php?controller=user&action=index');
                    exit();
                }
                if (!empty($user['avatar'])) {
                    @unlink($dir_uploads . $user['avatar']);
                }
                $is_update = $user_model->updateV2($id);
                if ($_SESSION['user']['username']==$user['username']){
                    unset($_SESSION['user']['avatar']);
                    $_SESSION['user']['avatar']=$image_name;
                }
                if ($is_update) {
                    $_SESSION['success'] = 'Update dữ liệu thành công';
                } else {
                    $_SESSION['error'] = 'Update dữ liệu thất bại';
                }
                header('Location: index.php?controller=user&action=index');
                exit();
            }
        }

        $this->content = $this->render('views/users/updateV2.php', [
            'user' => $user
        ]);

        require_once 'views/layouts/main.php';
    }

    public function register() {
        if ($_SESSION['user']['roleId']!=1) {
            header("Location: index.php?controller=user");
            exit();
        }
        if (isset($_POST['register'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $full_name = $_POST['fullName'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $status = $_POST['status'];
            $avatar_files = empty($_FILES['avatar']) ? "":$_FILES['avatar'];
            if (empty($username)) {
                $this->error = 'Ko đc để trống Tài khoản';
            } elseif (empty($password)){
                $this->error = 'Ko đc để trống Mật khẩu';
            }elseif (empty($full_name)){
                $this->error = 'Ko đc để trống Họ và tên';
            }elseif (empty($email)){
                $this->error = 'Ko đc để trống email';
            }elseif (empty($phone)){
                $this->error = 'Ko đc để trống Số điện thoại';
            }elseif (empty($status)){
                $status = 1;
            }else if ($avatar_files['error'] == 0) {
                $extension_arr = ['jpg', 'jpeg', 'gif', 'png'];
                $extension = pathinfo($avatar_files['name'], PATHINFO_EXTENSION);
                $extension = strtolower($extension);
                $file_size_mb = $avatar_files['size'] / 1024 / 1024;
                $file_size_mb = round($file_size_mb, 5);

                if (!in_array($extension, $extension_arr)) {
                    $this->error = 'Cần upload file định dạng ảnh';
                } else if ($file_size_mb >= 5) {
                    $this->error = 'File upload không được lớn hơn 5Mb';
                }
            }
            if (empty($this->error)) {
                $user_model = new User();
                $is_username_exists = $user_model->isUsernameExists($username);
                if ($is_username_exists) {
                    $this->error = 'Username đã tồn tại';
                } else {
                    $avatar = "";
                    if ($avatar_files['error'] == 0) {
                        $dir_uploads = __DIR__ . '/../assets/uploads';
                        if (!file_exists($dir_uploads)) {
                            mkdir($dir_uploads);
                        }
                        $avatar = time() . '-user-' . $avatar_files['name'];
                        move_uploaded_file($avatar_files['tmp_name'], $dir_uploads . '/' . $avatar);
                    }
                    $password = md5($password);
                    $is_register = $user_model->register($username, $password,$_SESSION['id'],$full_name,$email,$phone,$avatar,$status);
                    if ($is_register) {
                        $_SESSION['success'] = 'Thêm mới thành công';
                        header('Location: index.php?controller=user&action=index');
                        exit();
                    } else {
                        $this->error = "Không thể đăng ký";
                    }
                }
            }
        }

        $this->title_page = 'Trang đăng ký Người dùng';
        $this->content =
            $this->render('views/users/register.php');
        require_once 'views/layouts/main.php';
    }

    public function login() {
        if (isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            if (empty($username) || empty($password)) {
                $this->error = 'Phải nhập cả 2 trường';
            }
            if (empty($this->error)) {
                $userModel = new User();
                $password = md5($password);
                $user = $userModel
                    ->getUser($username, $password);
                if (!empty($user)) {
                    $_SESSION['user'] = $user;
                    $_SESSION['success'] = 'Đăng nhập thành công';
                    header('Location: index.php?controller=user');
                    exit();
                } else {
                    $this->error = 'Sai tài khoản hoặc mật khẩu';
                }
            }
        }

        $this->title_page = 'Trang đăng nhập';
        $this->content = $this->render('views/users/login.php');
        require_once 'views/layouts/main_login.php';
    }

}