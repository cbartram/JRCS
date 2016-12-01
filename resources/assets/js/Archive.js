/**
 * Created by christianbartram on 10/18/16.
 */
$(document).ready(function() {
    //Hide specific fields on page load (not monetary because thats the default)
    $("#type").hide();
    $("#inkind").hide();

    $("#donation-type").change(function() {
        //gets the selected attribute from the option list
        var type = $(this).find(':selected').attr('name');

        switch(type) {
            case 'monetary':
                $("#amount").show();
                $("#type").hide();
                $("#inkind").hide();
                break;
            case 'supplies':
                $("#amount").hide();
                $("#type").show();
                $("#inkind").hide();
                break;
            case 'inkind':
                $("#amount").hide();
                $("#type").hide();
                $("#inkind").show();
                break;
        }

    });

    //handles re-opening a previously approved or denied donation request
    $(".btn-warning").click(function() {
      var id = $(this).attr("data-id");
       openDonation(id, function(callback) {
          if(callback == true) {
              toastr.success('Successfully Re-Opened Donation')
          } else {
              toastr.error("Failed to perform operation requested please try again...")
          }
       });
        $(this).parent().parent().remove();
    });

    //Handles appending the $ to the money field
    $("#amount").focus(function() {
        $(this).val('$' + $(this).val());
    });


    //Handles when a volunteer is un-archived
    $(".un-archive").click(function() {
       renewVolunteerById($(this).attr('data-id'), function(response) {
          if(response == "true") {
              toastr.success('Volunteer Profile has been renewed successfully');
              window.location.reload();
          }
       });
    });

    //Handles when a program is un-archived
    $(".renew-program").click(function() {
        renewProgramById($(this).attr('data-id'), function(response) {
           if(response == "true") {
               toastr.success('Program has been renewed successfully');
               window.location.reload();
           }
        });
    });

    //Handles when an event is renewed
    $(".renew-event").click(function() {
       renewEvent($(this).attr('data-id'), function(response) {
          if(response == "true") {
              toastr.success('Event has been renewed successfully');
              window.location.reload();
          }
       });
    });



});