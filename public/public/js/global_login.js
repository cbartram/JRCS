/**
 * Created by christianbartram on 9/14/16.
 */
$(document).ready(function() {
    var email, program, type, timestamp, alertText;

    //Hide the volunteer Login on page load
    $("#volunteer-login").hide();

    $("#staff-login-btn").click(function() {
        if($(this).attr("class") != "btn btn-primary disabled") {
            //show the staff login hide the volunteer login
            $("#staff-login, #forgot-password").show("slow");
            $("#volunteer-login, #volunteer-cico").hide();
        }

    });

    $("#volunteer-login-btn").click(function() {
        if($("#staff-login-btn").attr("class") != "btn btn-primary disabled") {
            //show the volunteer login and hide the staff login
            $("#volunteer-login").show("slow");
            $("#staff-login, #volunteer-program, #forgot-password").hide();
        }

    });

    $(".alert-danger").effect("shake");

    $(".btn-danger").click(function() {
        //clear the volunteer cico fields
        $('#volunteer-program').prop('selectedIndex',0);
        $('#volunteer-type').prop('selectedIndex', 0);
        $('#volunteer-email').text("");

        //Hide the volunteer Login portion
        $("#volunteer-login").hide();
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
        var date = new Date();
        timestamp = date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
        timestamp = formatDate(timestamp);
        email = $("#volunteer-email").val();

        if($("#volunteer-type").find(':selected').attr('name') == "default" || $("#volunteer-email").val().length == 0) {
            alertText = "You need to pick a Volunteer Type and enter a valid email before you can Check-in!";
            $("#alert-cico").addClass("alert alert-danger").html(alertText).effect("shake");

            //prevent the statements from processing further issues in the form
            e.preventDefault();

        } else {
            var alertSelector = $("#alert-cico");
            //The volunteer has selected program as the type but hasnt selected their program
            if ($("#volunteer-program").find(':selected').attr('name') == "default" && $("#volunteer-type").find(':selected').attr('name') == "program") {
                alertText = "You must select a specific program from the list below!";
                alertSelector.addClass("alert alert-danger").html(alertText).effect("shake");

                e.preventDefault();
            } else {
                //define the type and program
                type = $("#volunteer-type").find(':selected').attr('name');
                program = $("#volunteer-program").find(':selected').attr('name');

                //input looks good lets submit the GET Request
                $.get("/cico", {email: email, program: program, type: type, timestamp: timestamp})
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
        } //closes second else
    });



});

function formatDate(date) {
    var d = new Date(date);
    var hh = d.getHours();
    var m = d.getMinutes();
    var s = d.getSeconds();
    var dd = "AM";
    var h = hh;
    if (h >= 12) {
        h = hh-12;
        dd = "PM";
    }
    if (h == 0) {
        h = 12;
    }
    m = m<10?"0"+m:m;

    s = s<10?"0"+s:s;

    /* if you want 2 digit hours:
     h = h<10?"0"+h:h; */

    var pattern = new RegExp("0?"+hh+":"+m+":"+s);

    var replacement = h+":"+m;
    replacement += ":"+s;
    replacement += " "+dd;

    return date.replace(pattern,replacement);
}
