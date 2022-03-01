<div class="right__title" >Thêm mới Người dùng</div>
<form method="post" action="" enctype="multipart/form-data">
    <div class="form-group">
        <label>Tài khoản</label>
        <input type="text" name="username" class="form-control" required/>
    </div>

    <div class="form-group">
        <label>Mật khẩu</label>
        <input type="password" name="password" class="form-control" required/>
    </div>

    <div class="form-group">
        <label>Họ và Tên</label>
        <input type="text" name="fullName" class="form-control" required/>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required/>
    </div>

    <div class="form-group">
        <label>Số điện thoại</label>
        <input type="text" name="phone" class="form-control" required/>
    </div>

    <div class="form-group">
        <label for="avatar">Ảnh đại diện</label>
        <input type="file" name="avatar" value="" class="form-control" id="avatar"/>
    </div>

    <div class="form-group">
        <label>Trạng thái</label>
        <select name="status" class="form-control">
            <option value="1" selected >Hoạt động</option>
            <option value="0" >Không hoạt động</option>
        </select>
    </div>

    <input type="submit" class="btn btn-primary" name="register" value="Save"/>
    <input type="reset" class="btn btn-secondary" name="submit" value="Reset"/>
</form>
<a class="btn btn-primary" href="index.php?controller=user">Trở lại</a>
