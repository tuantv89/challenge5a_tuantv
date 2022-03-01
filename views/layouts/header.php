<?php
$year = '';
$username = '';
$jobs = '';
$avatar = '';
?>
<div class="wrapper">
    <div class="container">
        <div class="dashboard">
            <div class="left">
                    <span class="left__icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                <div class="left__content">
                    <div class="left__logo">Quản lý sinh viên</div>
                    <div class="left__profile">
                        <div class="left__image">
                            <a href="<?php echo "index.php?controller=user&action=detail&id=".$_SESSION['user']['id']; ?>"><?php if (!empty($_SESSION['user']['avatar'])): ?>
                                <img height="160" src="assets/uploads/<?php echo $_SESSION['user']['avatar']; ?>"/>
                                <?php endif; ?> </a>
                        </div>
                        <a href="<?php echo "index.php?controller=user&action=detail&id=".$_SESSION['user']['id']; ?>"><p class="left__name"><?php echo $_SESSION['user']['username']; ?></p></a>
                    </div>
                    <ul class="left__menu">
                        <li class="left__menuItem">
                            <div class="left__title"><img src="assets/assets/icon-tag.svg" alt="">Challenge<img class="left__iconDown" src="assets/assets/arrow-down.svg" alt=""></div>
                            <div class="left__text">
                                <?php if ($_SESSION['user']['roleId']==1): ?>
                                <a class="left__link" href="<?php echo "index.php?controller=challenge&action=create"; ?>">Thêm Challenge</a>
                                <?php endif; ?>
                                <a class="left__link" href="<?php echo "index.php?controller=challenge"; ?>">Xem Challenge</a>
                            </div>
                        </li>
                        <li class="left__menuItem">
                            <div class="left__title"><img src="assets/assets/icon-edit.svg" alt="">Bài tập<img class="left__iconDown" src="assets/assets/arrow-down.svg" alt=""></div>
                            <div class="left__text">
                                <?php if ($_SESSION['user']['roleId']==1): ?>
                                <a class="left__link" href="<?php echo "index.php?controller=test&action=create"; ?>">Thêm bài tập</a>
                                <?php endif; ?>
                                <a class="left__link" href="<?php echo "index.php?controller=test"; ?>">Xem danh sách</a>
                            </div>
                        </li>
                        <li class="left__menuItem">
                            <div class="left__title"><img src="assets/assets/icon-user.svg" alt="">Người dùng<img class="left__iconDown" src="assets/assets/arrow-down.svg" alt=""></div>
                            <div class="left__text">
                                <?php if ($_SESSION['user']['roleId']==1): ?>
                                <a class="left__link" href="<?php echo "index.php?controller=user&action=register"; ?>">Thêm Người dùng</a>
                                <?php endif; ?>
                                <a class="left__link" href="<?php echo "index.php?controller=user&action=index"; ?>">Xem Người dùng</a>
                            </div>
                        </li>
                        <li class="left__menuItem">
                            <a href="<?php echo "index.php?controller=user&action=logout"; ?>" class="left__title"><img src="assets/icon-logout.svg" alt="">Đăng Xuất</a>
                        </li>
                    </ul>
                </div>
            </div>