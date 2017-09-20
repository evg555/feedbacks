$(document).ready(function (){

    //Обработка формы добавления отзыва
    var error = false;
    $("form#sendFeedback").on('submit',function(e){
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
                    $('form#sendFeedback').find("h3").before("<small class='error'>"+data['error']+"</small>");
                } else {
                    $('form#sendFeedback').replaceWith("<p class='success'>Ваш отзыв успешно отправлен и появится после прохождения модерации</p>")
                }
            }
        });
    });


    //Предварительный просмотр
    $("a.preview").on("click",function(e){
        e.preventDefault();

        var form = $("form#sendFeedback");

        if(!validate(form)) return false;

        var name = form.find("input[name='name']").val();
        var email = form.find("input[name='email']").val();
        var text =form.find("textarea").val();

        Data = new Date();
        var date = Data.toLocaleDateString();

        var preveiwFeedback = "  <div class=\"feedbacks-item previewFeedback\">\n" +
            "                        <div class=\"feedback-info\">\n" +
            "                            <div class=\"contacts\">\n" +
            "                                <p class=\"author\">"+name+"</p>\n" +
            "                                <p class=\"email\">"+email+"</p>\n" +
            "                            </div>\n" +
            "                            <div class=\"date\">\n" +
            "                                <p>"+date+"</p>\n" +
            "                            </div>\n" +
            "                        </div>\n" +
            "                        <div style=\"clear:both\"></div>\n" +
            "                        <div class=\"feedback-text\">\n" +
            "                            <p>"+text+"</p>\n" +
            "                        </div>\n" +
            "                    </div>";

        form.before(preveiwFeedback);
    });

});

//Валидация полей формы
function validate(form){
    var error = false;

    //Сброс ошибок валидации
    $(".error").remove();
    $(form).find("input[type='text'], textarea").css("border","");

    //Сброс предварительного просмотра, если есть
    $(".previewFeedback").remove();

    //Валидация данных
    $(form).find("input[type='text'], textarea").each(function(index,value){
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