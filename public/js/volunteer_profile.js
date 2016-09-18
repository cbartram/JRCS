/**
 * Created by christianbartram on 9/16/16.
 */

$(document).ready(function() {

    //todo This could probably be written better
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

        //Travels up the DOM searching for H4 tag with the CSS class user-name
        var user = $(this).parent().parent().parent().parent().find('.user-name').text();

        //todo Length need to be 12 in production
        var element = $(this).parent().parent().parent().find(".vol-id").text();
        var id = element.substr(element.length - 8, element.length);

        $("#table-body").load("../../application/model/volunteer_details.php?id=" + id);
        $(".modal-title").html(user + "'s Volunteer Details");
    });


});
