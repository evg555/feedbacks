<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Административная панель</title>

    <link rel="stylesheet" href="public/css/font-awesome.min.css">
    <link rel="stylesheet" href="public/css/main.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400;500;700;900&display=swap" rel="stylesheet">
</head>
<body>


    <header>
        <div class="container">
            <div class="flex justify-between items-center mt-[50px]">
                <h1 class="text-4xl font-bold">Административная панель</h1>

                <div class="flex flex-col">
                    <div>
                        <span class="user text-base"><?=$this->data['user']?></span>
                        <i class="fa fa-user-o" aria-hidden="true"></i>
                        <a class="login text-base" href="?logout=true">Выход</a>
                    </div>
                    <div>
                        <a class="login text-base" href="/">Вернуться на сайт</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="mt-16">
        <div class="container">
            <? foreach($this->data['feedbacks'] as $feed) {?>
                <div class="feedbacks-item w-full bg-lightgrey flex justify-between items-center mb-8 p-4 pr-8" data-id="<?=$feed['id']?>">
                    <div class="feedback-info max-w-[85%] flex gap-[18px] items-center">
                        <? if (!empty($feed['thumb'])):?>
                            <div class="thumb w-[30%] flex flex-col">
                                <img src="public/files/<?=$feed['thumb']?>" alt="thumb">
                            </div>
                        <?endif;?>

                        <div class="feedback-text">
                            <p title="Редактировать текст"><?=$feed['text']?></p>
                        </div>
                    </div>

                    <div>
                        <div class="feedback-status">
                            <? if (empty($feed['accept'])):?>
                                <a class="allow text-green-700 font-medium" href="">Принять</a>
                            <? else :?>
                                <a class="deny text-red-500 font-medium" href="">Отклонить</a>
                            <?endif;?>
                        </div>
                    </div>
                </div>
            <?}?>
        </div>
    </section>

    <script src="public/js/jquery-3.2.1.min.js"></script>
    <script src="public/js/custom.js"></script>
    <script src="public/js/admin.js"></script
</body>
</html>
