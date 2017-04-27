$(document).ready(function (e) {
    $(".form_edit_article").submit = function(e) {
        e.preventDefault();
        var datas = $(this).serialize();

        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:datas,
            dataType:'json',
            success:function(data){
                //document.location.href = "?action=edit_article";
                console.log('yo');
                console.log(data);

            }
        });
    };
});
