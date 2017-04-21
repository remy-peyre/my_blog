window.onload = function() {
    var errorBlockAddArticle = document.querySelector('#error-block-add-article');
    document.forms['add-article-form'].onsubmit = function () {
        errorBlockAddArticle.innerHTML = '';
        var params = 'title=' + this.elements['title'].value;
        params += '&image=' + this.elements['image'].addEventListener('change', function() {
                return this.files[0].name;
            });
        //params += '&image=' + this.elements['image'].value;
        params += '&content=' + this.elements['content'].value;
        var httpAddArticle = new XMLHttpRequest();
        httpAddArticle.open("POST", "?action=add-article", true);
        var url = "?action=add_article";
        httpAddArticle.open("POST", url, true);
        httpAddArticle.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        console.log(this.elements['image'].value);
        httpAddArticle.onload = function () {
            if (httpAddArticle.readyState == 4 && httpAddArticle.status == 200) {
                //document.location.href = "?action=edit_article";
            } else {
                var errors = JSON.parse(httpAddArticle.responseText);
                for (var error in errors['errors']) {
                    errorBlockAddArticle.innerHTML += errors['errors'][error] + '<br>';
                }
            }
        };
        httpAddArticle.send(params);
        return false;
    };

};
