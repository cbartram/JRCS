/**
 * Created by christianbartram on 9/14/16.
 */
$(document).ready(function() {
    $("#volunteer-login").hide();
    $("#staff-login-btn").click(function() {
        //show the staff login hide the volunteer login
        $("#staff-login").show("slow");
        $("#volunteer-login").hide();

    });

    $("#volunteer-login-btn").click(function() {
        //show the volunteer login and hide the staff login
        $("#volunteer-login").show("slow");
        $("#staff-login").hide();

    });


    $("#volunteer-login-submit").click(function(e) {
        var email = $('#volunteer-email').val();

        $.post("../../application/controller/global_volunteer_login_controller.php", {email: email})
            .done(function(data) {
                var alertText;

                if(data == false) {
                    alertText = email +  " is not a valid volunteer in the database...";
                    $("#alert-volunteer").addClass("alert alert-danger").html(alertText).effect("shake");
                } else {
                    alertText = "Success, logging in!";

                    $("#alert-volunteer").attr("class", "alert alert-success").html(alertText);
                    //hide volunteer login & show volunteer program/CICO
                }
            });

        e.preventDefault();

    });


    //Handles the login button
   $("#jaco, #jbc, #bebco, #admin").click(function(e) {
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