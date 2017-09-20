$(document).ready(function (){

    //Обработка формы добавления отзыва
    var error = false;
    $("form#sendFeedback").on('submit',function(e){
        e.preventDefault();
        //Сброс ошибок валидации
        $(".error").remove();
        $(this).find("input[type='text'], textarea").css("border","");

        //Валидация данных
        $(this).find("input[type='text'], textarea").each(function(index,value){
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

        if (error) return false;

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
});

