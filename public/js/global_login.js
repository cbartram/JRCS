/**
 * Created by christianbartram on 9/14/16.
 */
$(document).ready(function() {
    
   $(".btn-sm").click(function(e) {
        //When a user clicks on the login button remove the logout notification
        $(".alert-success").remove();

        //Variable Declarations
        var loginType = $(this).attr("data-login-type");
        var email = $("#inputEmail").val();
        var password = $("#inputPassword").val();
        var rememberMe = false;

        if ($("#remember-me").is(":checked")) {
            rememberMe = true;
        }
       console.log(rememberMe);

        //Asynchronous POST request to php passing the loginType as a JSON parameter
        $.post("../../application/controller/global_login_controller.php", {login_type: loginType, email: email, password: password, remember_me: rememberMe})
            .done(function(data) {
                //When the server returns a response
                if(data == false) {
                    var alertText = "";
                    if(email == "" || password == "") {
                       alertText = "You must feel out all the fields!"
                    } else {
                        alertText = "Wrong Username or Password!"
                    }
                    $("#alert").addClass("alert alert-danger").html(alertText).effect("shake");
                } else {
                    window.location.href = "../../application/view/volunteer_profile.php";
                }
            });

       //prevents auto refresh of the console for debugging
       e.preventDefault();
   })
});