<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Административная панель</title>
    <!-- JQuery files -->
    <script src="<?=TEMPLATE_DIR_URL?>/js/jquery-3.2.1.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=TEMPLATE_DIR_URL?>/css/font-awesome.min.css">
    <!-- Bootstrap files -->
    <link rel="stylesheet" href="<?=TEMPLATE_DIR_URL?>/css/bootstrap.min.css">
    <script src="<?=TEMPLATE_DIR_URL?>/js/bootstrap.min.js"></script>
    <!-- Custom files -->
    <link rel="stylesheet" href="<?=TEMPLATE_DIR_URL?>/css/style.css">
    <link rel="stylesheet" href="<?=TEMPLATE_DIR_URL?>/css/admin.css">
    <script src="<?=TEMPLATE_DIR_URL?>/js/custom.js"></script>
</head>
<body>
<div class="container">
    <div class="row header">
        <div class="col-lg-10">
            <h1>Административная панель</h1>
        </div>
        <div class="col-lg-2">
            <span class="user"><?=$data['user']?></span>
            <i class="fa fa-user-o" aria-hidden="true"></i>
            <a class="login" href="?logout=true">Выход</a>
            <a class="login" href="/">Вернуться на сайт</a>
        </div>
    </div>
    <a class="send" href="">Сохранить</a>
    <div class="row content">
        <div class="col-lg-12 feedbacks">
            <? foreach($data['feedbacks'] as $feed) :?>
                <div class="feedbacks-item" data-id="<?=$feed['id']?>">
                    <div class="feedback-info">
                        <? if (!empty($feed['thumb'])):?>
                            <div class="thumb">
                                <img src="<?=TEMPLATE_DIR_URL . "/files/" . $feed['thumb']?>" alt="">
                            </div>
                         <?endif;?>
                    </div>
                    <div class="feedback-text">
                        <p><?=$feed['text']?></p>
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
            <?endforeach;?>
        </div>
        <a class="send" href="">Сохранить</a>
    </div>
</div>
</body>
</html>
