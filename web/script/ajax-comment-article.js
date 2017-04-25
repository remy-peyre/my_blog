var errorBlockComment = document.querySelector('#error-block-comment');
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
