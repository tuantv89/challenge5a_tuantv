<div class="right__title" >Danh sách Người dùng</div>
<?php if ($_SESSION['user']['roleId']==1): ?>
<a href="index.php?controller=user&action=register" >
    <button style="width: 100px; margin-bottom: 20px" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm mới</button>
</a>
<?php endif; ?>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Tên tài khoản</th>
        <th>Họ và tên</th>
        <th>Avatar</th>
        <th>Trạng thái</th>
        <th>Hành Động</th>
    </tr>
    <?php if (!empty($users)): ?>
        <?php foreach ($users as $user): ?>
            <tr >
                <?php
                $urlDetail = "index.php?controller=user&action=detail&id=" . $user['id'];
                $urlUpdate = "index.php?controller=user&action=update&id=" . $user['id'];
                $urlDelete = "index.php?controller=user&action=delete&id=" . $user['id'];
                ?>
                <td><?php echo $user['id']; ?></td>
                <td><a href="<?php echo $urlDetail; ?>"><?php echo $user['username']; ?></a></td>
                <td><?php echo $user['fullName']; ?></td>
                <td>
                    <?php if (!empty($user['avatar'])): ?>
                        <img height="100px" src="assets/uploads/<?php echo $user['avatar']; ?>"/>
                    <?php endif; ?>
                </td>
                <td><?php echo ($user['status']==1) ? "Hoạt động":"Không hoạt động"; ?></td>
                <td>
                    <a title="Chi tiết" href="<?php echo $urlDetail ?>"><img class="left__iconDown" src="assets/assets/icon-edit.svg" alt="Chi tiết"></a>
                    <?php if ($_SESSION['user']['id']==$user['id']): ?>
                    <a title="Update" href="<?php echo $urlUpdate ?>"><img class="left__iconDown" src="assets/assets/refresh.svg" height="35px" alt="Sửa"></a>
                    <?php endif; ?>
                    <?php if ($_SESSION['user']['roleId']==1 && $user['roleId']!=1): ?>
                    <a title="Update" href="<?php echo $urlUpdate ?>"><img class="left__iconDown" src="assets/assets/refresh.svg" height="35px" alt="Sửa"></a>
                    <a title="Xóa" href="<?php echo $urlDelete ?>" onclick="return confirm('Bạn chắc chắn muốn xóa Người dùng <?php echo $user['username'] ?>?')">
                        <img class="left__iconDown" src="assets/assets/icon-trash-black.svg" alt="Xóa"></a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach ?>

    <?php else: ?>
        <tr>
            <td colspan="7">Không có bản ghi nào</td>
        </tr>
    <?php endif; ?>
</table>

