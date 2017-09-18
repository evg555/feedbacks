<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Войти в административную панель</title>
    <!-- JQuery files -->
    <script src="<?=TEMPLATE_DIR_URL?>/js/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap files -->
    <link rel="stylesheet" href="<?=TEMPLATE_DIR_URL?>/css/bootstrap.min.css">
    <script src="<?=TEMPLATE_DIR_URL?>/js/bootstrap.min.js"></script>
    <!-- Custom files -->
    <link rel="stylesheet" href="<?=TEMPLATE_DIR_URL?>/css/style.css">
    <script src="<?=TEMPLATE_DIR_URL?>/js/custom.js"></script>
</head>
<body>
<div class="container">
    <div class="row content">
        <div class="col-lg-12">
            <form id="loginForm" action="">
                <h3>Войти в административную панель</h3>
                <input name ='login'type="text" required placeholder="Логин">
                <input name ='pass'type="password" required placeholder="Пароль">
                <button>Отправить</button>
            </form>
        </div>
    </div>
</div>



</body>
</html>
