$(document).ready(function() {
    function CKupdateCommentary(){
        for ( instance in CKEDITOR.instances )
            CKEDITOR.instances['editor'].updateElement();
    }
    $('.form_edit_article').on('submit',(function(e) {
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
            success:function(reponse){
                var res = JSON.parse(reponse);
                console.log(res);
                //document.location.href = "?action=edit_article";
            },
            error: function(reponse){
                console.log('errors');
                //$("#error-block-add-article").text("Veillez remplir tous les champs");
            }
        });
    }));

    /*$('').on('submit', function (e) {
        e.preventDefault(); // On empêche de soumettre le formulaire
        var $this = $(this); // L'objet jQuery du formulaire
        console.log("Okais");
        CKupdateCommentary();
        console.log($this.serialize());
        $.ajax({
            url: $this.attr('action'), // On récupère l'action (ici action.php)
            type: $this.attr('method'), // On récupère la méthode (post)
            data: $this.serialize(), // On sérialise les données = Envoi des valeurs du formulaire
            dataType: 'json', // JSON
            success: function (reponse) { // Si ça c'est passé avec succès
                // ici on teste la réponse
                console.log(reponse);
                if (data.reponse['success'] === 'ok') {
                    console.log("Success");
                    //document.location.href = "?action=edit_article";

                } else {
                    console.log("Error");
                    //console.log(data.reponse);
                }
            },
        });
    });*/
});