/**
 * Created by christian bartram on 10/17/16.
 * This file handles the bulk cico options for volunteers
 * and staff in the home page
 */
$(document).ready(function() {
    //Empty array to hold all the id's we are bulk checking out
    var ids = [];

    $(":checkbox").click(function() {
        var id = $(this).attr('name');

        if($(this).is(":checked")) {
            ids.push(id);
        } else {
            ids.splice(ids.indexOf(id), 1);
        }
        console.log(ids);
    });

    $("#check-out").click(function() {
        //for each id in the ids array check them out
        if(ids.length > 0) {
            for (var i = 0; i < ids.length; i++) {
                checkOut(ids[i], function(callback) {
                    if(callback == "true") {
                        toastr.success('Volunteers checked out successfully!');
                    } else {
                        toastr.error('An error occurred when attempting to checkout please try again....');
                    }
                });
                //todo even if the checkout fails it still hides the row so you cant retry
                $('#' + ids[i]).hide("slide", {direction: "up"}, 500);
            }
        } else {
            toastr.error('No volunteers were selected to check out!');
            //No emails were selected to checkout
        }
    });

    var email, program, type, timestamp;

    //Variables for Defining selectors
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

                //Input has been Validated submit the post Request

                checkIn(email, type, program, function(data) {
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


function formatDate(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    return hours + ':' + minutes + ' ' + ampm;
}


    //start of the editable table plugin integration
    $('.table-bordered').Tabledit({
        url: '/api/v1/cico/update/',
        editButton: false,
        deleteButton: false,
        hideIdentifier: false,
        columns: {
            identifier: [0, 'id'],
            editable: [[3, 'timestamp']]
        },
        onAjax: function() {
            //when an ajax request is sent
            toastr.info('Attempting to update timestamp...');
        },
        onSuccess: function(data, textStatus, jqXHR) {
            console.log(data);
            if (data == false) {
                toastr.error('Error saving timestamp... The format must be YYYY-MM-DD H:MM AM/PM');
            } else {
                toastr.success('Your timestamp has been updated successfully!');

            }
        }
    });
});


