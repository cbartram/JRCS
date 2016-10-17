/**
 * Created by christianbartram on 9/14/16.
 */
$(document).ready(function() {
    var email, program, type, timestamp, alertText;

    //Variables for Defining selectors
    var alertSelector = $("#alert-cico");
    var programSelector = $("#volunteer-program");
    var typeSelector = $("#volunteer-type");
    var emailSelector = $("#volunteer-email");

    //Hide the Staff Login on page load
    $("#staff-login, #forgot-password, #volunteer-program").hide();

    $("#staff-login-btn").click(function() {
        if($(this).attr("class") != "btn btn-primary disabled") {
            //show the staff login hide the volunteer login
            $("#staff-login, #forgot-password").show("slow");
            $("#volunteer-login, #volunteer-cico, #checked-in-table").hide();
        }

    });

    $("#volunteer-login-btn").click(function() {
        if($("#staff-login-btn").attr("class") != "btn btn-primary disabled") {
            //show the volunteer login and hide the staff login
            $("#volunteer-login, #checked-in-table").show("slow");
            $("#staff-login, #volunteer-program, #forgot-password").hide();
        }

    });

    $(".alert-danger").effect("shake");


    typeSelector.change(function() {
        //gets the selected attribute from the option list
         program = $(this).find(':selected').attr('name');

        if(program == "program") {
            //Show the program option list
            $("#volunteer-program").show("slow");
        } else {
            $("#volunteer-program").hide("slow");
        }

    });

    programSelector.change(function() {
        type = $(this).find(":selected").attr('name');
    });

    $("#volunteer-cico-submit").click(function(e) {

        timestamp = formatDate(new Date());
        email = $("#volunteer-email").val();

        if($("#volunteer-type").find(':selected').attr('name') == "default" || emailSelector.val().length == 0) {
            alertText = "You need to pick a Volunteer Type and enter a valid email before you can Check-in!";
            $("#alert-cico").addClass("alert alert-danger").html(alertText).effect("shake");

            //prevent the statements from processing further issues in the form
            e.preventDefault();

        } else {

            //The volunteer has selected program as the type but hasnt selected their program
            if (programSelector.find(':selected').attr('name') == "default" && typeSelector.find(':selected').attr('name') == "program") {
                alertText = "You must select a specific program from the list below!";
                alertSelector.addClass("alert alert-danger").html(alertText).effect("shake");

                e.preventDefault();
            } else {

                //define the Volunteer Type & Program
                type = typeSelector.find(':selected').attr('name');
                program = programSelector.find(':selected').attr('name');

                //Input has been Validated submit the GET Request
                $.post("/cico", {email: email, program: program, type: type, timestamp: timestamp})
                    .done(function (data) {

                        //Handle response from the CicoController
                        switch(data) {
                            case 'false':
                                alertText = "<li>You haven't checked-out yet with the email: <b>" + email + "</b></li><li>You can check-out <a href='/checkout'>here!</a></li>";
                                alertSelector.addClass("alert alert-danger").html(alertText);
                                break;
                            case 'email':
                                alertText = "<li>The email you entered was incorrect</li><li> No volunteer found with the email: <b>" + email + "</b></li>";
                                alertSelector.addClass("alert alert-danger").html(alertText);
                                break;
                            case 'true':
                                alertText = "Checked in <b>" + email + "</b> at " + timestamp;
                                alertSelector.attr("class", "alert alert-success").html(alertText);
                                break;

                        }
                        console.log(data);
                    });

                e.preventDefault();
            }
        }
    });
});


function formatDate(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    return hours + ':' + minutes + ' ' + ampm;
}
