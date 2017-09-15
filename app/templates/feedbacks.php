<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Отзывы</title>
    <!-- JQuery files -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Bootstrap files -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <!-- Custom files -->
    <link rel="stylesheet" href="css/style.css">
    <script src="js/custom.js"></script>
</head>
<body>
    <div class="container">
        <div class="row header">
            <div class="col-lg-10">
                <h1>Отзывы</h1>
            </div>
            <div class="col-lg-2">
                <i class="fa fa-user-o" aria-hidden="true"></i>
                <a class="login" href="login.php">Вход в панель</a>
            </div>
        </div>
        <div class="row content">
            <div class="col-lg-9 feedbacks">
                <div class="feedbacks-item">
                    <div class="feedback-info">
                        <div class="contacts">
                            <p class="author">Автор</p>
                            <p class="email">e-mail</p>
                        </div>
                        <div class="date">
                            <p>Дата создания</p>
                        </div>
                    </div>
                    <div style="clear:both"></div>
                    <div class="feedback-text">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, animi eius fuga incidunt ipsum natus nihil pariatur perferendis porro provident unde vero. Adipisci, cupiditate, non? Accusamus cum ex quod sint?</p>
                        <small>*изменен администратором</small>
                    </div>
                </div>
                <div class="feedbacks-item">
                    <div class="feedback-info">
                        <div class="contacts">
                            <p class="author">Автор</p>
                            <p class="email">e-mail</p>
                        </div>
                        <div class="date">
                            <p>Дата создания</p>
                        </div>
                    </div>
                    <div style="clear:both"></div>
                    <div class="feedback-text">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, animi eius fuga incidunt ipsum natus nihil pariatur perferendis porro provident unde vero. Adipisci, cupiditate, non? Accusamus cum ex quod sint?</p>
                        <small>*изменен администратором</small>
                    </div>
                </div>
                <div class="feedbacks-item">
                    <div class="feedback-info">
                        <div class="contacts">
                            <p class="author">Автор</p>
                            <p class="email">e-mail</p>
                        </div>
                        <div class="date">
                            <p>Дата создания</p>
                        </div>
                    </div>
                    <div style="clear:both"></div>
                    <div class="feedback-text">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, animi eius fuga incidunt ipsum natus nihil pariatur perferendis porro provident unde vero. Adipisci, cupiditate, non? Accusamus cum ex quod sint?</p>
                        <small>*изменен администратором</small>
                    </div>
                </div>
                <div class="feedbacks-item">
                    <div class="feedback-info">
                        <div class="contacts">
                            <p class="author">Автор</p>
                            <p class="email">e-mail</p>
                        </div>
                        <div class="date">
                            <p>Дата создания</p>
                        </div>
                    </div>
                    <div style="clear:both"></div>
                    <div class="feedback-text">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, animi eius fuga incidunt ipsum natus nihil pariatur perferendis porro provident unde vero. Adipisci, cupiditate, non? Accusamus cum ex quod sint?</p>
                        <small>*изменен администратором</small>
                    </div>
                </div>
                <form action="">
                    <h3>Оставить отзыв</h3>
                    <input name ='name'type="text" required placeholder="Имя">
                    <input name ='email'type="email" required placeholder="E-mail">
                    <textarea name="text"  cols="30" rows="10" required placeholder="Текст сообщения"></textarea>
                    <label for="file">Прикрепить изображение</label>
                    <input name="file" type="file">
                    <div class="buttons">
                        <a class="preview" href="">Просмотр</a>
                        <a class="send" href="">Отправить</a>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 sidebar">
                <h4>Сортировать по:</h4>
                <a href="">дате</a>
                <a href="">автору</a>
                <a href="">e-mail</a>
            </div>
        </div>
    </div>
</body>
</html>
