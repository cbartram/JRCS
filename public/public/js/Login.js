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

    $(".alert-danger").effect("shake");
    programSelector.hide();


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
            toastr.warning('You need to pick a Volunteer Type and enter a valid email before you can Check-in!');

            //prevent the statements from processing further issues in the form
            e.preventDefault();

        } else {

            //The volunteer has selected program as the type but hasnt selected their program
            if (programSelector.find(':selected').attr('name') == "default" && typeSelector.find(':selected').attr('name') == "program") {
                toastr.warning('You must select a specific program from the list below!');

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
                                toastr.error("You haven't checked out yet with the email: <b>" + email + "</b>");
                                break;
                            case 'email':
                                toastr.error("The email you entered could not be found <b>" + email + "</b>");
                                break;
                            case 'true':
                                toastr.success("Checked in <b>" + email + "</b> at " + timestamp);
                                window.location.reload();
                                break;

                        }
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
