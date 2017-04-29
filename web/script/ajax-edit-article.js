$(document).ready(function() {
    function CKupdateCommentary(){
        for ( instance in CKEDITOR.instances )
            CKEDITOR.instances['editor'].updateElement();
    }
    $(document).ready(function() {

        // process the form
        $('.form_edit_article').submit(function(event) {
            CKupdateCommentary();
            $('.error_edit_article').removeClass('has-error'); // remove the error class

            // get the form data
            // there are many ways to get this data using jQuery (you can use the class or id also)
            var formData = {
                'title' 				: $('input[name=article_title]').val(),
                'content' 			: $('input[name=editor]').val(),
                'image' 	: $('input[name=article_image]').val()
            };

            // process the form
            $.ajax({
                type 		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                url 		: '?action=edit_article', // the url where we want to POST
                data 		: formData, // our data object
                dataType 	: 'json', // what type of data do we expect back from the server
                encode 		: true
            })
            // using the done promise callback
                .done(function(data) {

                    // log data to the console so we can see
                    console.log(data);

                    // here we will handle errors and validation messages
                    if ( ! data.success) {

                        // handle errors for name ---------------
                        if (data.errors.title) {
                            console.log("erreur");
                        }

                        // handle errors for email ---------------
                        if (data.errors.content) {
                            console.log("erreur");
                        }

                        // handle errors for superhero alias ---------------
                        if (data.errors.image) {
                            console.log("erreur");
                        }

                    } else {

                       console.log("success");

                    }
                })

                // using the fail promise callback
                .fail(function(data) {

                    // show any errors
                    // best to remove for production
                    console.log(data);
                });

            // stop the form from submitting the normal way and refreshing the page
            event.preventDefault();
        });

    });

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