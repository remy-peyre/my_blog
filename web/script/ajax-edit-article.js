$(document).ready(function (e) {
    $(".form_edit_article").submit = function(e) {
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
                //document.location.href = "?action=edit_article";
                console.log(data);
            },
            error: function(data){
                $("#error-block-add-article").text("Veillez remplir tous les champs");
            }
        });
    };
});
