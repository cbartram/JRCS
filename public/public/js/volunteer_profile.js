/**
 * Created by christianbartram on 9/16/16.
 */

$(document).ready(function() {

    //Handles add and removing the "active" css class when these elements are clicked
    $("#add-volunteer").click(function() {
        $(this).addClass("active");
        $("#profile").removeClass("active");
        $("#messages").removeClass("active");
    });

    $("#profile").click(function() {
        $(this).addClass("active");
        $("#messages").removeClass("active");
        $("#add-volunteer").removeClass("active");
    });

    $("#messages").click(function() {
        $(this).addClass("active");
        $("#add-volunteer").removeClass("active");
        $("#profile").removeClass("active");
    });

    
    $(".btn-success").click(function() {

        //Travels up the DOM searching for H4 tag with the CSS class user-name could be done better
        var user = $(this).parent().parent().parent().parent().find('.user-name').text();

        //Trims the users name
        //user = user.substr(0, user.indexOf("-") - 1);

        var element = $(this).parent().parent().parent().find(".vol-id").text();
        var id = element.substr(element.length - 12, element.length);

        $(".modal-title").html(user + "'s Volunteer Details");
    });


});
