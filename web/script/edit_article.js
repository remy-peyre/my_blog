window.onload = function() {
    var edit_article_button = document.querySelectorAll(".edit_article_button");
    $( ".edit_article_button" ).click(function() {
        $(this).next('.form_edit_article').css('display', 'block');
    });
};