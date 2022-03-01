<div class="right__title" >Cập nhật Người dùng <?php echo $user['username'] ?></div>
<a href="<?php echo "index.php?controller=user&action=updateV2&id=".$user['id']; ?>"><button style="width: 230px; margin-bottom: 20px" class="btn btn-primary">Cập nhật ảnh đại diện bằng URL</button></a>
<form method="post" action="" enctype="multipart/form-data">
    <?php if ($_SESSION['user']['roleId']==1 && $user['id']!=$_SESSION['user']['id']): ?>
    <div class="form-group">
        <label>Tên tài khoản</label>
        <input type="text" name="username" class="form-control" />
    </div>
    <div class="form-group">
        <label>Họ và tên</label>
        <input type="text" name="fullName" class="form-control" />
    </div>
    <?php endif; ?>
    <div class="form-group">
        <label>Mật khẩu mới</label>
        <input type="password" name="password" class="form-control" />
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="<?php echo $user['email'] ?>" class="form-control" />
    </div>

    <div class="form-group">
        <label>Số điện thoại</label>
        <input type="text" name="phone" value="<?php echo $user['phone'] ?>" class="form-control" />
    </div>

    <div class="form-group">
        <label for="avatar">Ảnh đại diện</label>
        <input type="file" name="avatar" value="" class="form-control" id="avatar"/>
        <?php if (!empty($user['avatar'])): ?>
            <br>
            <img height="120" src="assets/uploads/<?php echo $user['avatar']; ?>"/> <br>
            <?php echo "assets/uploads/".$user['avatar']; ?>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <?php
        $selected_active = '';
        $selected_disabled = '';
            switch ($user['status']) {
                case 0:
                    $selected_disabled = 'selected';
                    break;
                case 1:
                    $selected_active = 'selected';
                    break;
            }
        ?>
        <label>Trạng thái</label>
        <select name="status" class="form-control">
            <option value="1" <?php echo $selected_active ?> >Hoạt động</option>
            <option value="0" <?php echo $selected_disabled ?> >Không hoạt động</option>
        </select>
    </div>
    </div>

    <input type="submit" class="btn btn-primary" name="update" value="Save"/>
    <input type="reset" class="btn btn-secondary" name="submit" value="Reset"/>
</form>
<a class="btn btn-primary" href="index.php?controller=user">Trở lại</a>