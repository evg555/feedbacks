<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Войти в административную панель</title>

    <link rel="stylesheet" href="public/css/main.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400;500;700;900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="max-w-xs mx-auto pt-28">
            <form id="loginForm" action="../../index.php" method="post">
                <h3 class="text-2xl font-medium text-center mb-8">Войти в административную панель</h3>
                <input class="input mb-3" name="login" type="text" placeholder="Логин">
                <input class="input mb-5" name="pass" type="password" placeholder="Пароль">
                <input type="text" name="action" value="sendCredentials" hidden>
                <button class="btn">ОТПРАВИТЬ</button>
            </form>
        </div>
    </div>

    <!-- JQuery files -->
    <script src="public/js/jquery-3.2.1.min.js"></script>
    <script src="public/js/custom.js"></script>
    <script src="public/js/login.js"></script>
</body>
</html>
