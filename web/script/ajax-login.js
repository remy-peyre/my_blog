window.onload = function() {
    var errorBlockLogin = document.querySelector('#error-block-login');
    var successBlockLogin = document.querySelector('#success-block-login');
    document.forms['login-form'].onsubmit = function () {
        successBlockLogin.innerHTML = '';
        errorBlockLogin.innerHTML = '';
        var params = 'username=' + this.elements['username'].value;
        params += '&password=' + this.elements['password'].value;

        var httpLogin = new XMLHttpRequest();
        httpLogin.open("POST", "?action=login", true);
        var url = "?action=login";
        httpLogin.open("POST", url, true);
        httpLogin.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        httpLogin.onload = function () {
            if (httpLogin.readyState == 4 && httpLogin.status == 200) {
                document.location.href = "?action=home";
            } else {
                var errors = JSON.parse(httpLogin.responseText);
                for (var error in errors['errors']) {
                    errorBlockLogin.innerHTML += error + ' : ' + errors['errors'][error] + '<br>';
                }
            }
        };
        httpLogin.send(params);
        return false;
    };
};