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

});


