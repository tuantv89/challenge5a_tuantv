<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="assets/js/jquery-1.11.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</head>
<body>
    <?php require_once 'header.php';?>

    <div class="right">
        <?php if (!empty($this->error)): ?>
            <div class="alert alert-danger">
                <?php echo $this->error; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])):?>
            <div class="alert alert-danger">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])):?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>
        <div class="right__content">
            <div class="right__table">
                <div><?php echo $this->content; ?></div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>

    <?php require_once 'footer.php'; ?>

</body>
</html>
