/**
 * Created by christianbartram on 9/16/16.
 */

$(document).ready(function() {
    
    $(".btn-success").click(function() {

        //Travels up the DOM searching for H4 tag with the CSS class user-name
        var user = $(this).parent().parent().parent().parent().find('.user-name').text();

        //todo Length need to be 12 in production
        var element = $(this).parent().parent().parent().find(".vol-id").text();
        var id = element.substr(element.length - 8, element.length);

        //The volunteers name
        //user = user.substr(0, (user.length - 8));

        console.log('Name: ' + user);
        console.log("ID: " + id);

        $("#table-body").load("../../application/model/volunteer_details.php?id=" + id);
        $(".modal-title").html(user + "'s Volunteer Details");
    });


});
