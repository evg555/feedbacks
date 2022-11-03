$(document).ready(function (){

    //Принятие или отклонение отзывов
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

        //Получаем id отзыва
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

    //Редактировнаие текста отзыва
    $(".feedback-text p").on('click', function() {
        $("form#saveChangedText").remove();

        var id = $(this).closest(".feedbacks-item").data("id");
        var text = $(this).text();

        var form = "<form id='saveChangedText' class='row' method='post'>" +
            "           <textarea name='text' rows='3' class='col-lg-10'>"+text+"</textarea>" +
            "           <input type='text' name='id' value='"+id+"' hidden>" +
            "           <input type='text' name='action' value='saveChangedText' hidden>" +
            "           <button class='send'>Сохранить</button>" +
            "       </form>";

        $(this).closest(".feedbacks-item").after(form);
    });

    //Сохранение отредактированного отзыва
    $(document).on('submit',"form#saveChangedText",function(e){
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
                    $("form#saveChangedText").before("<small class='error'>"+data['error']+"</small>");
                } else {
                    $("form#saveChangedText").replaceWith("<p class='success'>Отзыв успешно изменен</p>")
                }
            }
        });
    });

});