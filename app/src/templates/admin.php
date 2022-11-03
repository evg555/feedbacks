<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Административная панель</title>
    <!-- JQuery files -->
    <script src="public/js/jquery-3.2.1.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="public/css/font-awesome.min.css">
    <!-- Bootstrap files -->
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <script src="public/js/bootstrap.min.js"></script>
    <!-- Custom files -->
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/admin.css">
    <script src="public/js/custom.js"></script>
    <script src="public/js/admin.js"></script>
</head>
<body>

<div class="container">
    <div class="row header">
        <div class="col-lg-10">
            <h1>Административная панель</h1>
        </div>
        <div class="col-lg-2">
            <span class="user"><?=$this->data['user']?></span>
            <i class="fa fa-user-o" aria-hidden="true"></i>
            <a class="login" href="?logout=true">Выход</a>
            <a class="login" href="/">Вернуться на сайт</a>
        </div>
    </div>

    <div class="row content">
        <div class="col-lg-12 feedbacks">
            <? foreach($this->data['feedbacks'] as $feed) {?>
                <div class="feedbacks-item" data-id="<?=$feed['id']?>">
                    <div class="feedback-info">
                        <? if (!empty($feed['thumb'])):?>
                            <div class="thumb">
                                <img src="public/files/<?=$feed['thumb']?>" alt="">
                            </div>
                         <?endif;?>
                    </div>
                    <div class="feedback-text">
                        <p title="Редактировать текст"><?=$feed['text']?></p>
                    </div>
                    <div class="feedback-status">
                        <? if (empty($feed['accept'])):?>
                            <a class="allow" href="">Принять</a>
                        <? else :?>
                            <a class="deny" href="">Отклонить</a>
                        <?endif;?>
                    </div>
                    <div style="clear:both"></div>
                </div>
            <?}?>
        </div>
    </div>
</div>
</body>
</html>
