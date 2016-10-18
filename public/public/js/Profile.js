/**
 * Created by christianbartram on 9/16/16.
 */

$(document).ready(function() {

    //hide the donations div by default
    $("#donations").hide();

    //Handles add and removing the "active" css class when these elements are clicked
    $("#add-volunteer").click(function() {
        $(this).addClass("active");
        $("#profile").removeClass("active");
        $("#messages").removeClass("active");
        $("#checkout-volunteer").removeClass("active");
    });

    $("#profile").click(function() {
        $(this).addClass("active");
        $("#messages").removeClass("active");
        $("#add-volunteer").removeClass("active");
        $("#checkout-volunteer").removeClass("active");

        //Show the donations that have been submitted in a table
        $("#donations").show();

    });

    $("#messages").click(function() {
        $(this).addClass("active");
        $("#add-volunteer").removeClass("active");
        $("#profile").removeClass("active");
        $("#checkout-volunteer").removeClass("active");

    });

    $("#checkout-volunteer").click(function() {
        $(this).addClass('active');
        $("#add-volunteer").removeClass("active");
        $("#profile").removeClass("active");
        $("#messages").removeClass("active");
    });

    
    $(".btn-success").click(function() {

        //Travels up the DOM searching for H4 tag with the CSS class user-name could be done better
        var user = $(this).parent().parent().parent().parent().find('.user-name').text();

        //Trims the users name
        //user = user.substr(0, user.indexOf("-") - 1);

        var element = $(this).parent().parent().parent().find(".vol-id").text();
        var id = element.substr(element.length - 12, element.length);

        getVolunteerById(id, function(output) {

            //Load the volunteer profile details
            $("#table-body").append('<tr><td>'
                + output.first_name + '</td><td>'
                + output.last_name + '</td><td>'
                + id + '</td><td>'
                + output.email + '</td><td>'
                + output.phone + '</td><td>'
                + output.city + '</td><td>'
                + output.state + '</td><td>'
                + output.zip_code + '</td></tr>');

        });

        $('#myModal').on('hidden.bs.modal', function () {
            $("#table-body").find("tr").remove();
        });

        $(".modal-title").html(user + "'s Volunteer Details");
    });


});
