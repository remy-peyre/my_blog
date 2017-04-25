$(document).ready(function (e) {
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

    $('#comment-form').on('submit',(function(e) {
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
                document.location.href = "?action=read_article&article="+matricule;
            },
            error: function(data){
                $("#error-block-comment-article").text("Veillez remplir le champs");
            }
        });
    }));
});
//};

/*var errorBlockComment = document.querySelector('#error-block-comment');
var matricule = document.querySelector('#matricule');
document.forms['comment-form'].onsubmit = function () {
    errorBlockComment.innerHTML = '';
    var params = 'content=' + this.elements['content'].value;

    var httpComment = new XMLHttpRequest();
    httpComment.open("POST", "?action=read_article&article=" + matricule, true);
    var url = "?action=read_article&article=" + matricule;
    httpComment.open("POST", url, true);
    httpComment.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    httpComment.ready = function () {
        if (httpComment.readyState == 4 && httpComment.status == 200) {
            //document.location.href = url;
            console.log(url);
        } else {
            var errors = JSON.parse(httpComment.responseText);
            for (var error in errors['errors']) {
                errorBlockComment.innerHTML += error + ' : ' + errors['errors'][error] + '<br>';
            }
        }
    };
    httpComment.send(params);
    return false;
};
*/