$(document).ready(function (){

    //Обработка формы добавления отзыва
    var formSendfeedback = $("form#sendFeedback");
    var formAutorization = $("form#loginForm");

    formSendfeedback.on('submit',function(e){
        e.preventDefault();

        if(!validate(this)) return false;

        //Отправка формы на сервер
        var formData = new FormData(this);

        //Показываем прелоадер
        $(this).find('.form-content').css('opacity','0.6');
        $('.before-load').show();

        $.ajax({
            url: "/send",
            type: "POST",
            dataType: "json",
            data:formData,
            processData: false,
            contentType: false,
            success: function(data){
                $('.before-load').hide();
                formSendfeedback.find('.form-content').css('opacity',"1");

                if (!data['success']){
                    formSendfeedback.find("h3").before("<small class='error'>"+data['error']+"</small>");
                } else {
                    formSendfeedback.replaceWith("<p class='success'>Ваш отзыв успешно отправлен и появится после прохождения модерации</p>")
                }
            }
        });
    });

    //Обработка формы авторизации
    formAutorization.on('submit',function(e){
        e.preventDefault();

        if(!validate(this)) return false;

         //Отправка формы на сервер
        var formData = new FormData(this);

        $.ajax({
            url: "/send",
            type: "POST",
            dataType: "json",
            data:formData,
            processData: false,
            contentType: false,
            success: function(data){
                if (!data['success']){
                    formAutorization.find("h3").after("<small class='error'>"+data['error']+"</small>");
                } else {
                    window.location.href = "/admin";
                }
            }
        });
    });

    //Предварительный просмотр
    formSendfeedback.find("input[name='file']").on("change",function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.preview-item .feedback-image img').attr('src', e.target.result);
            };

            reader.readAsDataURL(this.files[0]);
        }
    });

    $("a.preview").on("click",function(e){
        e.preventDefault();

        if(!validate(formSendfeedback)) return false;

        var name = formSendfeedback.find("input[name='name']").val();
        var email = formSendfeedback.find("input[name='email']").val();
        var text =formSendfeedback.find("textarea").val();

        var input = formAutorization.find("input[name='file']");
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                imageSrc = e.target.result;
                $('.feedback-image img').attr('src', imageSrc);
            };
        }

        Data = new Date();
        var date = Data.toLocaleDateString();

        var previewDiv = $(".preview-item");

        previewDiv.find(".author").text(name);
        previewDiv.find(".email").text(email);
        previewDiv.find(".date").text(date);
        previewDiv.find(".feedback-text p").text(text);
        previewDiv.show();


    });

    //Принятие илиотклонение отзывов
    $(".feedback-status a").on('click',function(e){
        e.preventDefault();

        $(".error").remove();

        var accept;
        var item  = this;

        if ($(this).hasClass("allow")){
            accept = 1;
        } else if ($(this).hasClass("deny")){
            accept = 0;
        } else return false;

        //Получаем id тзыва
        var id = $(this).closest(".feedbacks-item").data("id");

        $.ajax({
            url: "/send",
            type: "POST",
            dataType: "json",
            data: {
                action: "acceptFeedback",
                id: id,
                accept: accept
            },
            success: function(data){
                if (!data['success']){
                    $(item).closest(".feedbacks-item").before("<small class='error'>"+data['error']+"</small>");
                } else {
                    window.location.href = "/admin";
                }
            }
        });
    });

    //Валидация полей формы
    function validate(form){
        var error = false;

        //Сброс ошибок валидации
        $(".error").remove();
        $(form).find("input[type='text'], textarea").css("border","");

        //Сброс предварительного просмотра, если есть
        $(".preview-item").hide();

        //Валидация данных
        $(form).find("input[type='text'], input[type='password'],textarea").each(function(index,value){
            if($(this).val() == ''){
                $(this).css("border","2px solid red");
                $(this).before("<small class='error'>*Поле обязательно для заполнения!</small>");
                error = true;
                return false;
            }

            if ($(this).attr("name") == "email"){
                var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

                if(reg.test($(this).val()) == false) {
                    $(this).css("border","2px solid red");
                    $(this).before("<small class='error'>*Введите корректный e-mail!</small>");
                    error = true;
                    return false;
                }
            }
        });

        return !error;
    }
});

