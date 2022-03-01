<div class="right__title" >Challenge: <?php echo $challenge['title']; ?></div>

<table class="table table-bordered">
    <tr>
        <th>Tên Challenge</th>
        <td><?php echo $challenge['title']; ?></td>
    </tr>
    <tr>
        <th>Người tạo</th>
        <td><?php echo $challenge['username']; ?></td>
    </tr>
    <tr>
        <th>Gợi ý</th>
        <td><?php echo $challenge['suggest'] ?></td>
    </tr>
</table>
<a style="margin-bottom: 40px" class="btn btn-primary" href="index.php?controller=challenge">Trở lại</a>
<div class="right__title" >Đáp án</div>
<?php if (!empty($result) && $check == true): ?>
<div>
    <h2>Bạn trả lời Đúng</h2>
    <h4>Đáp án:</h4>
    <?php echo $result;?>
</div>
<?php elseif (empty($result) && $check == true): ?>
<h2>Bạn trả lời sai</h2>
<?php endif; ?>

<div class="right__title" ></div>
<form method="post" action="" enctype="multipart/form-data">
    <div class="form-group">
        <label>Nhập câu trả lời</label>
        <input type="text" name="answer" required class="form-control">
    </div>
    <input type="submit" class="btn btn-primary" name="submit" value="Trả lời"/>
</form>