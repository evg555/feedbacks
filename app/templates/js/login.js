$(document).ready(function (){

    //Обработка формы авторизации
    var formAutorization = $("form#loginForm");

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

});

