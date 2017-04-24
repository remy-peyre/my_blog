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
    var matricule = decodeURI( $_GET( 'user' ) );

    var showMe = document.getElementById(matricule);
    showMe.style.display = "block";
}
