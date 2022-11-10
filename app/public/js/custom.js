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
            $(this).before("<p class='error'>*Поле обязательно для заполнения!</p>");
            error = true;
            return false;
        }

        if ($(this).attr("name") == "email"){
            var reg = /^([A-Za-z0-9_\-.])+@([A-Za-z0-9_\-.])+\.([A-Za-z]{2,4})$/;

            if(reg.test($(this).val()) == false) {
                $(this).css("border","2px solid red");
                $(this).before("<p class='error'>*Введите корректный e-mail!</p>");
                error = true;
                return false;
            }
        }
    });

    return !error;
}

