window.onload = function() {
    var edit_profil = document.getElementById('edit_profil');
    var form_edit_profil = document.getElementById('form_edit_profil');
    var border_profil_box = document.getElementById('border_profil_box');
    edit_profil.onclick=function(){
        form_edit_profil.style.display = "block";
        border_profil_box.style.display = "none";
    }
}

