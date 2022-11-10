<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Отзывы</title>

    <link rel="stylesheet" href="../public/css/font-awesome.min.css">
    <link rel="stylesheet" href="../public/css/main.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400;500;700;900&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <div class="container">
            <div class="flex mt-[50px] justify-between items-center">
                <h1 class="text-4xl font-bold">Отзывы</h1>
                <div>
                    <i class="fa fa-user-o" aria-hidden="true"></i>
                    <a class="login" href="/login">Вход в панель</a>
                </div>
            </div>
        </div>
    </header>

    <section>
        <div class="container">
            <div class="flex mt-20 gap-28">
                <div class="feedbacks w-[75%]">
                    <?if (empty($this->data)) {?>
                        <div class="feedbacks-item bg-lightgrey p-6 mb-[70px]">
                            <p>Отзывов нет</p>
                        </div>
                    <?}?>

                    <? foreach ($this->data as $feedback) {?>
                        <div class="feedbacks-item bg-lightgrey p-6 mb-[70px]">
                            <div class="feedback-info flex justify-between mb-7">
                                <div class="contacts">
                                    <p class="author text-base"><?=$feedback['name']?></p>
                                    <p class="email text-base italic"><?=$feedback['email']?></p>
                                </div>
                                <div class="date">
                                    <p><?=$feedback['created']?></p>
                                </div>
                            </div>

                            <div class="flex gap-12">
                                <? if (!empty($feedback['image'])) {?>
                                    <div class="feedback-image w-80">
                                        <img src="public/files/<?=$feedback['image']?>" alt="">
                                    </div>
                                <?}?>

                                <div class="feedback-text">
                                    <p class="text-base"><?=$feedback['text']?></p>
                                    <p class="font-bold text-[12px] italic"><?=(empty($feedback['changed']) ? ""
                                            : "*изменен администратором")?></p>
                                </div>
                            </div>
                        </div>
                    <?}?>

                    <div class="feedbacks-item preview-item bg-lightgrey p-6 mb-[70px] border-[3px] border-darkblue
                        border-dashed hidden">
                        <div class="feedback-info flex justify-between mb-7">
                            <div class="contacts">
                                <p class="author text-base"></p>
                                <p class="email text-base italic"></p>
                            </div>
                            <div class="date"></div>
                        </div>

                        <div class="flex gap-12">
                            <div class="feedback-image w-80">
                                <img src="" alt="">
                            </div>

                            <div class="feedback-text">
                                <p class="text-base"></p></div>
                        </div>
                    </div>
                </div>

                <div class="sidebar w-[25%]">
                    <h3 class="text-2xl font-medium">Сортировать по:</h3>

                    <ul class="mt-3">
                        <li class="text-lightblue text-base"><a href="?sort=byDate">дате</a></li>
                        <li class="text-lightblue text-base"><a href="?sort=byAuthor">автору</a></li>
                        <li class="text-lightblue text-base"><a href="?sort=byEmail">email</a></li>
                    </ul>
                <div>
            </div>
        </div>
    </section>

    <section id="form">
        <div class="container mb-[50px]">
            <div class="max-w-sm">
                <form class="relative" id="sendFeedback" method="post">
                    <div class="before-load">
                        <i class="fa fa-spinner fa-spin"></i>
                    </div>

                    <div class="form-content flex flex-col">
                        <h3 class="text-2xl font-medium mb-4">Оставить отзыв</h3>
                        <input class="input mb-3" name="name" type="text" placeholder="Имя">
                        <input class="input mb-3" name="email" type="text" placeholder="E-mail">
                        <textarea class="input mb-5" name="text"  cols="30" rows="10"
                                  placeholder="Текст сообщения"></textarea>
                        <label class="text-base mb-5" for="file">Прикрепить изображение (JPG, GIF, PNG)</label>
                        <input name="file" type="file" accept=".jpg, .jpeg, .png, .gif">
                        <input type="text" name="action" value="sendFeedback" hidden>

                        <div class="buttons mt-5">
                            <a class="preview inline-block mb-5 max-w-fit font-bold text-base
                                text-lightblue" href="">ПРЕДВАРИТЕЛЬНЫЙ ПРОСМОТР</a>
                            <button class="send btn">ОТПРАВИТЬ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script src="../public/js/jquery-3.2.1.min.js"></script>
    <script src="../public/js/custom.js"></script>
    <script src="../public/js/feedbacks.js"></script>
</body>
</html>
