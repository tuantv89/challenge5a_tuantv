<div class="right__title" >Chi tiết bài tập</div>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <td><?php echo $test['id']; ?></td>
    </tr>
    <tr>
        <th>Name</th>
        <td><?php echo $test['nameTest']; ?></td>
    </tr>
    <tr>
        <th>Người Đăng</th>
        <td><?php echo $test['username']; ?></td>
    </tr>
    <tr>
        <th>Download</th>
        <td>
            <a href="<?php echo "index.php?controller=test&action=download&id=".$test['id']; ?>">Download</a>
        </td>
    </tr>
    <tr>
        <th>Status</th>
        <td>
            <?php
            $status_text = 'Active';
            if ($test['status'] == 0) {
                $status_text = 'Disabled';
            }
            echo $status_text;
            ?>
        </td>
    </tr>
    <tr>
        <th>Created_at</th>
        <td>
            <?php echo date('d-m-Y H:i:s', strtotime($test['createdAt'])); ?>
        </td>
    </tr>
</table>
<a class="btn btn-primary" href="index.php?controller=test">Back</a>
<br> <br>
<div class="right__title" >Nộp bài</div>
<form method="post" action="index.php?controller=submit&action=create" enctype="multipart/form-data">
    <div class="form-group">
        <input type="hidden" name="testId" value="<?php echo $test['id']; ?>">
        <input type="hidden" name="testName" value="<?php echo $test['nameTest']; ?>">
        <label>Chọn File nộp</label>
        <input type="file" name="link" required class="form-control" id="category-avatar"/>
    </div>
    <input type="submit" class="btn btn-primary" name="submit" value="Nộp bài"/>
</form>
<?php if(true): ?>
    <br>
<div class="right__title" >Danh sách Người dùng bài nộp</div>
<table class="table table-bordered">
    <tr>
        <th>Người nộp</th>
        <th>Download</th>
        <th>Thời gian</th>
    </tr>
    <?php if (!empty($submits)): ?>
        <?php foreach ($submits as $submit): ?>
            <tr >
                <td><?php echo $submit['username']; ?></td>
                <td><a href="<?php echo "index.php?controller=submit&action=download&id=".$submit['id']; ?>">Download</a></td>
                <td><?php echo date('d-m-Y H:i:s', strtotime($submit['createdAt'])); ?></td>
            </tr>
        <?php endforeach ?>
    <?php else: ?>
        <tr>
            <td colspan="5">Không có lời nhắn!</td>
        </tr>
    <?php endif; ?>
</table>
<?php endif; ?>