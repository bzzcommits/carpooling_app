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

function sakrijMenu(){
    var vr = $("#sakrijMenu").html();
    
    $("#contact").html("");
    $("#profile").html("");
    $("#drive").html("");
    $("#home").html("");
    //$("#exampleAccordion").css("display", "none");
    //$("#page-top").css( "width", $( window ).width()*0.9 + "px");
    //$(".content-wrapper").css("maxWidth", $( window ).width()*0.9 + "px");

}
/*

function sakrijMenu(){
    var vr = $("#sakrijMenu").html();
    
    getElementById("contact").style.display = "none";
    getElementById("profile").style.display = "none";
    getElementById("drive").style.display = "none";
    getElementById("home").style.display = "none";
    $("#exampleAccordion").width("50px");

}
*/
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
        
        $("#sakrijMenu").on( "click", sakrijMenu);
        
        $("#DateNew").datepicker({dateFormat: "yy-mm-dd"});
        $("#Date").datepicker({dateFormat: "yy-mm-dd"});
        
        $("#searchId").on( "click", pronadiKorisnika );
    }
);
