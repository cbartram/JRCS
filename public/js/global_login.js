/**
 * Created by christianbartram on 9/14/16.
 */
$(document).ready(function() {
    
   $(".btn-sm").click(function(e) {
        var loginType = $(this).attr("data-login-type");
        var email = $("#inputEmail").val();
        var password = $("#inputPassword").val();
        var rememberMe = false;

        if ($("#remember-me").is(":checked")) {
            rememberMe = true;
        }
       console.log(rememberMe);
        //Asychronous post request to php passing the loginType as a JSON parameter
        $.post("../../application/controller/global_login_controller.php", {login_type: loginType, email: email, password: password, remember_me: rememberMe})
            .done(function(data) {
                //when the server returns a response
                if(data == false) {
                    $("#alert").addClass("alert alert-danger").html("Incorrect Username or Password.");
                    $(".alert-success").remove();
                } else {
                    window.location.href = "../../application/view/volunteer_profile.php";
                }
            });

       //prevents auto refresh of the console for debugging
       e.preventDefault();
   })
});