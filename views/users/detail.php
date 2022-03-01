<div class="right__title" >Chi tiết Người dùng <?php echo $user['username'] ?></div>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <td><?php echo $user['id']; ?></td>
    </tr>
    <tr>
        <th>Tài khoản</th>
        <td><?php echo $user['username']; ?></td>
    </tr>
    <tr>
        <th>Chức vụ</th>
        <td><?php echo ($user['roleId']==1)?"Giáo viên":"Sinh viên"; ?></td>
    </tr>
    <tr>
        <th>Người tạo tài khoản</th>
        <td><a href="index.php?controller=user&action=detail&id=<?php echo $owenr['id'] ?>"><?php echo $owenr['username'] ?></a></td>
    </tr>
    <tr>
        <th>Email</th>
        <td><?php echo $user['email']; ?></td>
    </tr>
    <tr>
        <th>Số điện thoại</th>
        <td><?php echo $user['phone']; ?></td>
    </tr>
    <tr>
        <th>Avatar</th>
        <td>
            <?php if (!empty($user['avatar'])): ?>
                <img src="assets/uploads/<?php echo $user['avatar'] ?>" height="120px"/>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <th>Status</th>
        <td>
            <?php
            $status_text = 'Hoạt động';
            if ($user['status'] == 0) {
                $status_text = 'Không hoạt động';
            }
            echo $status_text;
            ?>
        </td>
    </tr>
    <tr>
        <th>Created_at</th>
        <td>
            <?php echo date('d-m-Y H:i:s', strtotime($user['createdAt'])); ?>
        </td>
    </tr>
    <tr>
        <th>Updated_at</th>
        <td>
            <?php echo date('d-m-Y H:i:s', strtotime($user['updatedAt'])); ?>
        </td>
    </tr>
</table>
<a style="margin-bottom: 40px" class="btn btn-primary" href="index.php?controller=user">Trở lại</a>
<div class="right__title" >Tin nhắn của Người dùng <?php echo $user['username'] ?></div>
<table class="table table-bordered">
    <tr>
        <th>Người nhắn</th>
        <th>Nội dung</th>
        <th>Thời gian</th>
        <th>Thời gian sửa</th>
        <th>Hành động</th>
    </tr>
    <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $comment): ?>
            <tr >
                <td><?php echo $comment['username']; ?></td>
                <td><?php echo $comment['content']; ?></td>
                <td><?php echo $comment['createdAt']; ?></td>
                <td><?php echo $comment['updatedAt']; ?></td>
                <td>
                    <?php
                    $urlUpdate = "index.php?controller=user&action=detail&id=" .$user['id']. "&comment=".$comment['id'];
                    $urlDelete = "index.php?controller=comment&action=delete&id=" . $comment['id']."&back=".$user['id'];
                    ?>
                    <?php if ($_SESSION['user']['id']==$comment['userId'] ): ?>
                        <a title="Update" href="<?php echo $urlUpdate ?>"><img class="left__iconDown" src="assets/assets/refresh.svg" height="35px" alt="Sửa"></a>
                        <a title="Xóa" href="<?php echo $urlDelete ?>" onclick="return confirm('Bạn chắc chắn muốn xóa Comment?')">
                            <img class="left__iconDown" src="assets/assets/icon-trash-black.svg" alt="Xóa"></a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach ?>
    <?php else: ?>
    <tr>
        <td colspan="5">Không có lời nhắn!</td>
    </tr>
    <?php endif; ?>
</table>
<div class="right__title" ></div>
<?php
$urlCreate = "index.php?controller=comment&action=create&back=".$user['id'];
$url_update = !empty($comment_get['id'])? "index.php?controller=comment&action=update&id=".$comment_get['id']."&back=".$user['id'] :"";
?>
<form method="post" action="<?php echo empty($comment_get['id'])? $urlCreate: $url_update ?>" enctype="multipart/form-data">
    <div class="form-group">
        <label>Nội dung</label>
        <textarea required name="content" id="summary" class="form-control"><?php echo (!empty($comment_get['content'])) ? $comment_get['content']:""; ?></textarea>
    </div>
    <input type="submit" class="btn btn-primary" name="submit" value="Nhắn"/>
</form>