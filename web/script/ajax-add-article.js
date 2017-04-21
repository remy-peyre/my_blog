$(document).ready(function (e) {
    $('#add-article-form').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                console.log("success");
                console.log(data);
                //$("#add-article-form").submit();
                document.location.href = "?action=edit_article";
                /*}else{
                    $("#error-block-add-article").text("Veillez remplir tous les champs");
                }*/
            },
            error: function(data){
                console.log("error");
                console.log(data);
                //$("#error-block-add-article").text(data['responseText']);
                var resErrors = (data['responseText']);
                //$("#error-block-add-article").text(resErrors);
                $("#error-block-add-article").text("Veillez remplir tous les champs");
                console.log(resErrors);

            }
        });
    }));

    /*$("#image").on("change", function() {
            $("#add-article-form").submit();
    });*/
});
//};
