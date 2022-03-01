<div class="right__title" >Cập nhật Ảnh đại diện Người dùng <?php echo $user['username'] ?> Bằng URL</div>
<a href="<?php echo "index.php?controller=user&action=update&id=".$user['id'];?>"><button style="width: 100px; margin-bottom: 20px" class="btn btn-primary">Trở lại</button></a>
<form method="post" action="" enctype="multipart/form-data">
    <div class="form-group">
        <label>URL</label>
        <input type="text" required name="url" value="" class="form-control" />
    </div>
    <input type="submit" class="btn btn-primary" name="update" value="Save"/>
    <input type="reset" class="btn btn-secondary" name="submit" value="Reset"/>
</form>
<a class