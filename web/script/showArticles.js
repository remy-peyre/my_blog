window.onload = function() {
    function $_GET(param) {
        var vars = {};
        window.location.href.replace( location.hash, '' ).replace(
            /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
            function( m, key, value ) { // callback
                vars[key] = value !== undefined ? value : '';
            }
        );
        if ( param ) {
            return vars[param] ? vars[param] : null;
        }
        return vars;
    }
    var matricule = decodeURI( $_GET( 'article' ) );

    var showMe = document.getElementById(matricule);
    showMe.style.display = "block";

    /*$('#comment-form').submit(function(e) {
        var $this = $(this);
        $.ajax({
            type: $this.attr('method'),
            url: $this.attr('action'),
            data: $this.serialize(),
            success:function(data){
                //document.location.href = "?action=read_article&article="+matricule;
                console.log(data);
            },
            error: function(data){
                console.log(data);
                //$("#error-block-comment-article").text("Veillez remplir le champs");
                //console.log("Veillez remplir le champs");
            }
        });
    });*/

}
