/**
 * Created by christianbartram on 9/16/16.
 */

$(document).ready(function() {
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




    $(function() {
        var from, to, id;
        $(".panel-body").sortable({
            connectWith: ".panel-sortable",
            handle: ".portlet-header",
            cancel: ".portlet-toggle",
            placeholder: "portlet-placeholder ui-corner-all",
            out:function(event, ui) {
              from = $.trim($(this).prev().text());
            },
            receive:function(event, ui) {
                var sub = ui.item.children().text();
                id = sub.substring(sub.indexOf(':') + 1, sub.indexOf(':') + 13);
                to = $.trim($(this).prev().text());

                //Removes the volunteer from their original group
                updateVolunteerById(id, dbSanitize(from), 0, function(callback) {
                   console.log(callback);
                });

                //Adds the volunteer to the new group
                updateVolunteerById(id, dbSanitize(to), 1, function(callback) {
                    console.log('Callback2' + callback);
                });
            }
        });
        $(".portlet")
            .addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
            .find(".portlet-header")
            .addClass( "ui-widget-header ui-corner-all");
    });


    function dbSanitize(group) {
        switch(group) {
            case 'BEBCO':
                return 'bebco_volunteer';
                break;
            case 'JACO':
                return 'jaco_volunteer';
                break;
            case 'JBC':
                return 'jbc_volunteer';
                break;
            default:
                return 'false';
        }
    }


});
