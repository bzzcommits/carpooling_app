function handlePasswords(){
    var txt_psw = $("#psw").val();
    var txt_cnf = $("#cnf").val();

    if(txt_psw !== txt_cnf){
        $("#sgnup").attr('disabled', 'disabled');
        $("#mssg").html("Passwords aren't matching!");
    }
    else{
        $("#sgnup").removeAttr('disabled');
        if(txt_cnf !== '')
            $("#mssg").html("Passwords are matching!");
        else
            $("#mssg").html("");
    }
}

function handleLogout(){
    var r = confirm("Do you really want to log out?");
    if(r !== true)
        $(this).attr('href', window.location.href);
}


$(document).ready(
    function() {
        // klik na logout
        $("#lgout").on("click", handleLogout)

        // provjera druge lozinke
        $("#cnf").on("input", handlePasswords);
        $("#psw").on("input", handlePasswords);

        // U kartici Drive, odi na stranicu ovisno o buttonu...
        $("#search_drive").on("click", function(){
          window.location.href = window.location.pathname+"?rt=pretrazi";
        });
        $("#offer_drive").on("click", function(){
          window.location.href = window.location.pathname+"?rt=pretrazi/offers";
        });
    }
);
