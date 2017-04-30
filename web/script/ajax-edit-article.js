$(document).ready(function (e) {
    function CKupdateCommentary(){
        for ( instance in CKEDITOR.instances )
            CKEDITOR.instances['editor'].updateElement();
    }
    $('.form_edit_article').on('submit',(function(e) {
        e.preventDefault();
        CKupdateCommentary();
        var formData = new FormData(this);
        console.log("OK");
        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                console.log(data);
                document.location.href = "?action=edit_article";
            },
            error: function(data){
                $("#error-block-add-article").text("Veillez remplir tous les champs");
            }
        });
    }));
});