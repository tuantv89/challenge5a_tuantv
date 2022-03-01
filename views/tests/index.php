<div class="right__title" >Danh sách Bài tập</div>
<?php if ($_SESSION['user']['roleId']==1): ?>
    <a href="index.php?controller=test&action=create" >
        <button style="width: 100px; margin-bottom: 20px" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm mới</button>
    </a>
<?php endif; ?>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Tên bài tập</th>
        <th>Người đăng</th>
        <th>Download</th>
        <th>Trạng thái</th>
        <th>Ngày đăng</th>
        <th>Hành Động</th>
    </tr>
  <?php if (!empty($tests)): ?>
    <?php foreach ($tests as $test): ?>
          <tr>
              <?php
              $urlDetail = "index.php?controller=test&action=detail&id=" . $test['id'];
              $urlDelete = "index.php?controller=test&action=delete&id=" . $test['id'];
              ?>
              <td>
                <?php echo $test['id']; ?>
              </td>
              <td><a href="<?php echo "index.php?controller=test&action=detail&id=".$test['id']; ?>">
                <?php echo $test['nameTest']; ?></a>
              </td>
              <td>
                  <?php echo $test['username']; ?>
              </td>
              <td>
                  <a href="<?php echo "index.php?controller=test&action=download&id=".$test['id']; ?>">Download</a>
              </td>
              <td>
                <?php
                $status_text = 'Hoạt động';
                if ($test['status'] == 0) {
                  $status_text = 'Không hoạt động';
                }
                echo $status_text;
                ?>
              </td>
              <td>
                <?php echo date('d-m-Y H:i:s', strtotime($test['createdAt'])); ?>
              </td>
              <td>
                  <a title="Chi tiết" href="<?php echo $urlDetail ?>"><img class="left__iconDown" src="assets/assets/icon-edit.svg" alt="Chi tiết"></a>
                  <?php if ($_SESSION['user']['id']==$test['userId']): ?>
                      <a title="Xóa" href="<?php echo $urlDelete ?>" onclick="return confirm('Bạn chắc chắn muốn xóa Bài tập <?php echo $user['username'] ?>?')">
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

