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
                    $(item).closest(".feedbacks-item").before("<p class='error'>"+data['error']+"</p>");
                } else {
                    window.location.href = "/admin";
                }
            }
        });
    });

    //Редактирование текста отзыва
    $(".feedback-text p").on('click', function() {
        $("form#saveChangedText").remove();
        $(".error").hide();
        $(".success").hide();

        var id = $(this).closest(".feedbacks-item").data("id");
        var text = $(this).text();

        var form = "<form id='saveChangedText' method='post'>" +
                        "<div class='flex w-full justify-between items-center mb-8'>" +
                            "<div class='w-full'>" +
                                "<textarea class='input w-[95%]' name='text' rows='3'>"+text+"</textarea>" +
                                "<input type='text' name='id' value='"+id+"' hidden>" +
                                "<input type='text' name='action' value='saveChangedText' hidden>" +
                            "</div>" +
                            "<button class='send btn'>СОХРАНИТЬ</button>" +
                        "</div>" +
                    "</form>";

        $(this).closest(".feedbacks-item").after(form);
    });

    //Сохранение отредактированного отзыва
    $(document).on('submit',"form#saveChangedText",function(e){
        e.preventDefault();

        if(!validate(this)) return false;

        //Отправка формы на сервер
        var formData = new FormData(this);
        var id = formData.get('id');

        $.ajax({
            url: "/send",
            type: "POST",
            dataType: "json",
            data:formData,
            processData: false,
            contentType: false,
            success: function(data){
                if (!data['success']){
                    $("form#saveChangedText").before("<p class='error text-base mb-8'>"+data['error']+"</p>");
                } else {
                    $('[data-id="' + id + '"]').find('.feedback-text > p').text(formData.get('text'));
                    $("form#saveChangedText").replaceWith("<p class='success mb-8'>Отзыв успешно изменен</p>")
                }
            }
        });
    });

});