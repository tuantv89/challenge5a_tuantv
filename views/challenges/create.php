<div class="right__title" >Thêm mới Challenge</div>
<form method="post" action="" enctype="multipart/form-data">
    <div class="form-group">
        <label>Tên Challenge</label>
        <input type="text" name="title" required value="" class="form-control"/>
    </div>
    <div class="form-group">
        <label>Gợi ý</label>
        <input type="text" name="suggest" required value="" class="form-control"/>
    </div>

    <div class="form-group">
        <label>File Challenge (Chỉ được chọn file .txt)</label>
        <input type="file" accept=".txt" name="challenge" required class="form-control" id="category-avatar"/>
    </div>

    <div class="form-group">
        <label>Trạng thái</label>
        <select name="status" class="form-control">
            <option value="1" selected >Hoạt động</option>
            <option value="0" >Không hoạt động</option>
        </select>
    </div>

    <input type="submit" class="btn btn-primary" name="submit" value="Thêm"/>
    <input type="reset" class="btn btn-secondary" name="submit" value="Reset"/>
</form>