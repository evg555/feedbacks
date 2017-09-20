<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Отзывы</title>
    <!-- JQuery files -->
    <script src="<?=TEMPLATE_DIR_URL?>/js/jquery-3.2.1.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=TEMPLATE_DIR_URL?>/css/font-awesome.min.css">
    <!-- Bootstrap files -->
    <link rel="stylesheet" href="<?=TEMPLATE_DIR_URL?>/css/bootstrap.min.css">
    <script src="<?=TEMPLATE_DIR_URL?>/js/bootstrap.min.js"></script>
    <!-- Custom files -->
    <link rel="stylesheet" href="<?=TEMPLATE_DIR_URL?>/css/style.css">
    <script src="<?=TEMPLATE_DIR_URL?>/js/custom.js"></script>
</head>
<body>
    <div class="container">
        <div class="row header">
            <div class="col-lg-10">
                <h1>Отзывы</h1>
            </div>
            <div class="col-lg-2">
                <i class="fa fa-user-o" aria-hidden="true"></i>
                <a class="login" href="/login">Вход в панель</a>
            </div>
        </div>
        <div class="row content">
            <div class="col-lg-9 feedbacks">
                <? foreach ($data as $feedback) :?>
                    <div class="feedbacks-item">
                        <div class="feedback-info">
                            <div class="contacts">
                                <p class="author"><?=$feedback['name']?></p>
                                <p class="email"><?=$feedback['email']?></p>
                            </div>
                            <div class="date">
                                <p><?=$feedback['created']?></p>
                            </div>
                        </div>
                        <div style="clear:both"></div>
                        <div class="feedback-text">
                            <p><?=$feedback['text']?></p>
                            <small><?=(empty($feedback['changed']) ? "" : "*изменен администратором")?></small>
                        </div>
                    </div>
                <?endforeach;?>
                <form id="sendFeedback" method="post">
                    <h3>Оставить отзыв</h3>
                    <input name ='name'type="text"placeholder="Имя">
                    <input name ='email'type="text"placeholder="E-mail">
                    <textarea name="text"  cols="30" rows="10" placeholder="Текст сообщения"></textarea>
                    <label for="file">Прикрепить изображение</label>
                    <input name="file" type="file">
                    <input type="text" name="action" value="sendfeedback" hidden>
                    <div class="buttons">
                        <a class="preview" href="">Предварительный просмотр</a>
                        <button class="send">Отправить</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 sidebar">
                <h4>Сортировать по:</h4>
                <a href="?sort=byDate">дате</a>
                <a href="?sort=byAuthor">автору</a>
                <a href="?sort=byEmail">e-mail</a>
            </div>
        </div>
    </div>
</body>
</html>
