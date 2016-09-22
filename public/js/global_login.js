/**
 * Created by christianbartram on 9/14/16.
 */
$(document).ready(function() {
    var email, program, type;

    //Hide both the volunteer Login and Cico on page load
    $("#volunteer-login, #volunteer-cico").hide();

    $("#staff-login-btn").click(function() {
        if($(this).attr("class") != "btn btn-primary disabled") {
            //show the staff login hide the volunteer login
            $("#staff-login").show("slow");
            $("#volunteer-login").hide();
            $("#volunteer-cico").hide();
        }

    });

    $("#volunteer-login-btn").click(function() {
        if($("#staff-login-btn").attr("class") != "btn btn-primary disabled") {
            //show the volunteer login and hide the staff login
            $("#volunteer-login").show("slow");
            $("#staff-login").hide();
        }

    });

    $(".btn-danger").click(function() {
        //todo this transition needs to be more smooth
        $("#alert-cico").removeClass("alert alert-danger").html("");

        //remove the disabled state for the staff login button
        $("#staff-login-btn").attr("class", "btn btn-primary");

        //Hide both the volunteer Login and Cico on page load
        $("#volunteer-login, #volunteer-cico").hide();
        $("#staff-login").show("slow");

    });

    $('#volunteer-type').change(function() {
        //gets the selected attribute from the option list
         program = $(this).find(':selected').attr('name');

        if(program == "program") {
            //Show the program option list
            $("#volunteer-program").show("slow");
        } else {
            $("#volunteer-program").hide("slow");
        }

    });

    $("#volunteer-program").change(function() {
        type = $(this).find(":selected").attr('name');
    });

    $("#volunteer-cico-submit").click(function(e) {

        //todo needs AM/PM and its in 24 hour time needs converting to 12 hour time
        var date = new Date();
        var timestamp = date.getHours() + ":" + date.getMinutes();

        $.post("../../application/controller/clock_in.php", {email: email, program: program, type: type, timestamp: timestamp})
            .done(function(data) {
                var alertText;

                //If the user hasnt filled out the form at all
                if($("#volunteer-type").find(':selected').attr('name') == "default") {
                    alertText = "You need to pick a Volunteer Type before you can Check-in";

                    $("#alert-cico").addClass("alert alert-danger").html(alertText).effect("shake");

                } else {

                    //the user filled out the form
                    if (data == false) {
                        alertText = "You haven't clocked out yet with the email: <b>" + email + "</b>";
                        $("#alert-cico").addClass("alert alert-danger").html(alertText).effect("shake");
                    } else {
                        alertText = "Checked in <b>" + email + "</b> at " + timestamp;
                        $("#alert-cico").attr("class", "alert alert-success").html(alertText);
                        //Re-enable to Staff Login button
                        $("#staff-login-btn").attr("class", "btn btn-primary");

                    }
                }

            });

        e.preventDefault();
    });


    $("#volunteer-login-submit").click(function(e) {
         email = $('#volunteer-email').val();

        $.post("../../application/controller/global_volunteer_login_controller.php", {email: email})
            .done(function(data) {
                var alertText;

                if(data == false) {
                    alertText = "<b>" + email +  "</b> is not a valid volunteer in the database";
                    $("#alert-volunteer").addClass("alert alert-danger").html(alertText).effect("shake");
                } else {
                    //hide volunteer login & show volunteer program/CICO
                    $("#staff-login-btn").attr("class", "btn btn-primary disabled");
                    $("#volunteer-login").hide();

                    //Reset form fields from previous Check-in
                    $('#volunteer-program').prop('selectedIndex',0);
                    $('#volunteer-type').prop('selectedIndex', 0);


                    $("#volunteer-cico").show("slow");
                    $("#volunteer-program").hide();

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