window.onload = function(){
    var errorBlock = document.querySelector('#error-block');
    var successBlock = document.querySelector('#success-block');
    document.forms['register-form'].onsubmit = function(){
        successBlock.innerHTML = '';
        errorBlock.innerHTML = '';
        var params = 'username='+this.elements['username'].value;
        params += '&password='+this.elements['password'].value;
        params += '&verifpassword='+this.elements['verifpassword'].value;
        params += '&firstname='+this.elements['firstname'].value;
        params += '&lastname='+this.elements['lastname'].value;
        params += '&birthday='+this.elements['birthday'].value;


        var http = new XMLHttpRequest();
        http.open("POST", "?action=register", true);
        var url = "?action=register";
        http.open("POST", url, true);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        http.onload = function() {
            if(http.readyState == 4 && http.status == 200) {
                document.location.href="?action=login";
            }else{
                var errors = JSON.parse(http.responseText);
                for(var error in errors['errors']){
                    errorBlock.innerHTML += errors['errors'][error]+'<br>';
                }
            }
        };
        http.send(params);
        return false;
    };
};