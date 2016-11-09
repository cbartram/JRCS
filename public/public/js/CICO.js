/**
 * Created by christian bartram on 10/17/16.
 * This file handles the bulk cico options for volunteers
 * and staff in the home page
 */
$(document).ready(function() {
    //Empty array to hold all the id's we are bulk checking out
    var emails = [];

    $(":checkbox").click(function() {
        var email = $(this).attr('name');

        if($(this).is(":checked")) {
            emails.push(email);
        } else {
            emails.splice(emails.indexOf(email), 1);
        }
        console.log(emails);
    });

    $("#check-out").click(function() {
        //for each id in the ids array check them out
        if(emails.length > 0) {
            for (var i = 0; i < emails.length; i++) {
                checkOut(emails[i], function(callback) {
                    console.log(callback);
                });
            }
            window.location.reload();
            toastr.success('Volunteers checked out successfully!');
        } else {
            toastr.error('No volunteers were selected to check out!');
            //No emails were selected to checkout
        }
    });

});


