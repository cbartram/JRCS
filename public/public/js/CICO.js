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
                toastr.error('Your timestamp must be in the format YYYY-MM-DD H:MM AM/PM Timestamp has not yet been saved.');
            } else {
                toastr.success('Your timestamp has been updated successfully!');

            }
        }
    });
});


