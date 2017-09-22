$(document).ready(function (){

    //Обработка формы добавления отзыва
    var formSendfeedback = $("form#sendFeedback");

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
});