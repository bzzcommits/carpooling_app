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

function handleLogin(event) {
    var username = $("._username").val();
    var password = $("._password").val();
    $.ajax(
    {
      url: window.location.pathname + "?rt=home/login",
      data: { username: username, password: password},
      type: 'POST',
      dataType: "json",
      success: function( data )
      {
        console.log("data je ", JSON.stringify(data));
        if( data.error !== "" )
          alert( data.error );
        else
          window.location.href = window.location.pathname+"?rt=home";
      },
  		error: function( xhr, status )
  		{
      console.log("handleLogin :: error :: status = " + status );
  		}
    });
}

function handleNewPassword(event){
  var username = $("#newpassus").html();
  var password = $("#newpass").val();
  console.log("ispis: " + username + " " + password);
  $.ajax(
  {
    url: window.location.pathname + "?rt=home/setNewPassword",
    data: { username: username, password: password},
    type: 'POST',
    dataType: "json",
    success: function( data )
    {
      console.log("data je ", JSON.stringify(data));
      alert( data.msg );
      window.location.href = window.location.pathname+"?rt=home/login";
    },
    error: function( xhr, status )
    {
      console.log("handleLogin :: error :: status = " + status );
    }
  });
}

function handleReset(event) {
    var email = $("#exampleInputEmail1").val();
    $.ajax(
    {
      url: window.location.pathname + "?rt=home/forgotPassword",
      data: { email: email},
      type: 'POST',
      dataType: "json",
      success: function( data )
      {
        console.log("data je ", JSON.stringify(data));
        alert( data.msg );
        window.location.href = window.location.pathname+"?rt=home";
      },
  		error: function( xhr, status )
      {
        console.log("handleLogin :: error :: status = " + status );
  		}
    });
}

function handleSignUp(event) {
    var username = $("#exampleInputUsername1").val();
    var email = $("#exampleInputEmail1").val();
    var password = $("#psw").val();
    $.ajax(
    {
      url: window.location.pathname + "?rt=home/signup",
      data: { username: username, email: email, password: password},
      type: 'POST',
      dataType: "json",
      success: function( data )
      {
        console.log("data je ", JSON.stringify(data));
        alert( data.msg );
        window.location.href = window.location.pathname+"?rt=home";
      },
  		error: function( xhr, status )
  		{
      console.log("handleLogin :: error :: status = " + status );
  		}
    });
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


function pronadiKorisnika() {}


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

function checkIfDriver(event){
  $.ajax(
  {
    url: window.location.pathname + "?rt=user/chechIfDriver",
    data: {check:1},
    type: 'POST',
    dataType: "json",
    success: function( data )
    {
      console.log("data je ", JSON.stringify(data));
      if(data.error === "")
        window.location.href = window.location.pathname+"?rt=pretrazi/offers";
      else
        alert( data.error );
    },
    error: function( xhr, status )
    {
      console.log("handleLogin :: error :: status = " + status );
    }
  });
}

$(document).ready(
    function() {
        $("#lgout").on("click", handleLogout);
        $("#login").on("click", handleLogin);
        $("#resetbtn").on("click", handleReset);
        $("#newpassbtn").on("click", handleNewPassword);
        $("#sgnup").on("click", handleSignUp);

        // provjera druge lozinke
        $("#cnf").on("input", handlePasswords);
        $("#psw").on("input", handlePasswords);

        // U kartici Drive, odi na stranicu ovisno o buttonu...
        $("#search_drive").on("click", function(){
          window.location.href = window.location.pathname+"?rt=pretrazi";
        });

        $("#offer_drive").on("click", checkIfDriver);

        $("#sakrijMenu").on( "click", sakrijMenu);

        $("#DateNew").datepicker({dateFormat: "yy-mm-dd",
                                    minDate:new Date()});
        $("#Date").datepicker({dateFormat: "yy-mm-dd",
                                    minDate:new Date()});

        $("#searchId").on( "click", pronadiKorisnika );


        $( "body" ).on( "click", "button.otkaziRezervaciju", otkaziRezervaciju );
        $( "body" ).on( "click", "button.otkaziVoznju", otkaziVoznju );
        $( "body" ).on( "click", "button.procitanaPoruka", procitanaPoruka );
        $( "body" ).on( "click", "button.ocjenjenaVoznja", ocjenjenaVoznja );

        //$(".suputnici").on("mouseover", prikazi_suputnike);
    }
);


function otkaziRezervaciju(event) {
    var ret = confirm("Are you sure you want to delete this reservation?");
    if (ret === true) {
        var gumb = $(this);
        var ime = gumb.prop("name");
        $.ajax(
            {
                url: window.location.pathname + "?rt=user/otkazanaRezervacija",
                data: { idVoznje: ime},
                type: 'POST',
        		dataType: "json",
    			success: function( data )
    			{
                    window.location.reload(false);
                    //console.log("uspjesno izbrisana rezervacija");
    			}
            }
        );
    }
}

function otkaziVoznju(event) {
    var ret = confirm("Are you sure you want to delete this drive?");
    if (ret === true) {
        var gumb = $(this);
        var ime = gumb.prop("name");
        $.ajax(
            {
                url: window.location.pathname + "?rt=user/otkazanaVoznja",
                data: { idVoznje: ime},
                type: 'POST',
        		dataType: "json",
    			success: function( data )
    			{
                    window.location.reload(false);
                    //console.log("uspjesno izbrisana voznja");
    			}
            }
        );
    }
}

function procitanaPoruka(event) {
    alert("The driver canceled this drive!");

    var gumb = $(this);
    var ime = gumb.prop("name");
    $.ajax(
        {
            url: window.location.pathname + "?rt=user/procitanaPoruka",
            data: { idVoznje: ime},
            type: 'POST',
    		dataType: "json",
			success: function( data )
			{
                window.location.reload(false);
                console.log("uspjesno procitana poruka");
			}
        }
    );

}

function ocjenjenaVoznja(event) {
    var gumb = $(this);
    var ime = gumb.prop("name");
    var ocjena = Number ( $("#ocjena").val() );
    var komentar = $("#komentar").val();
    if ( ocjena < 1 || ocjena > 5 )
        alert("The grade has to be between 1 and 5");

    var reg = /^([\w.,]|\s){2,100}$/;    // slova, znamenke, underscore, tocka, zarez

    if ( reg.test(komentar) === false )
        alert("The comment has to have between 2 and 100 characters (letters, numbers, spaces, dot or comma)");

    else {
        $.ajax(
            {
                url: window.location.pathname + "?rt=user/unesenKomentar",
                data: { idVoznje: ime, ocjena: ocjena, komentar: komentar},
                type: 'POST',
        		dataType: "json",
    			success: function( data )
    			{
                    window.location.reload(false);
                    // console.log("uspjesno unesen komentar");
    			}
            }
        );
    }
}
