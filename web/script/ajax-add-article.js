$(document).ready(function (e) {
    function CKupdateCommentary(){
        for ( instance in CKEDITOR.instances )
            CKEDITOR.instances['editor'].updateElement();
    }
    $('#add-article-form').on('submit',(function(e) {
        e.preventDefault();
        CKupdateCommentary();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                document.location.href = "?action=edit_article";
            },
            error: function(data){
                $("#error-block-add-article").text("Veillez remplir tous les champs");
            }
        });
    }));
});
//};
