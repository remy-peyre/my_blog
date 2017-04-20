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
    var deco_var = decodeURI( $_GET( 'article' ) );
    console.log(deco_var);

    var section = document.querySelectorAll(".articles");
    var showMe = document.getElementById(deco_var);
    console.log(showMe);
    showMe.style.display = "block";
}
