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
                checkOut(ids[i], function(callback) {});

                $('#' + ids[i]).hide("slide", {direction: "up"}, 500);
            }
            toastr.success('Volunteers checked out successfully!');
        } else {
            toastr.error('No volunteers were selected to check out!');
            //No emails were selected to checkout
        }
    });

});


