/**
 * Created by christianbartram on 9/16/16.
 */

$(document).ready(function() {
    //Holds array of id's the staff member wishes to remove from the system
    var deleteArray = [];

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

    //Add Date pickers from jqueryUI to date selectors
    $("#start-date, #end-date").datepicker();

    //Handles emptying the trash!
    $("#delete").click(function() {
       for(var i = 0; i < deleteArray.length; i++) {
           deleteVolunteerById(deleteArray[i], function(callback) {
               window.location.reload();
               toastr.success("Volunteer has been <strong>deleted</strong> successfully!");
           });

       }
    });

    //Handles sorting and dragging volunteer cards
    $(function() {
        var from, to, id;
        $(".panel-body").sortable({
            connectWith: ".panel-sortable",
            handle: ".portlet-header",
            cancel: ".portlet-toggle",
            placeholder: "portlet-placeholder ui-corner-all",
            remove:function(event, ui) {
                from = $.trim($(this).prev().text());
            },
            receive:function(event, ui) {
                var sub = ui.item.children().text();
                id = sub.substring(sub.indexOf(':') + 1, sub.indexOf(':') + 13);
                to = $.trim($(this).prev().text());

                if(to != 'Delete Volunteer') {
                    //Show the alert
                    $("#copy").modal();
                } else {
                    deleteArray.push(id);
                    console.log(deleteArray);
                }

                //they have moved a volunteer out of the delete box
                if(from == 'Delete Volunteer') {
                    var index = deleteArray.indexOf(id);
                    deleteArray.splice(index, 1);
                    console.log(deleteArray);
                }

                $("#copy-btn").click(function() {
                    //Adds the volunteer to the new group without removing from the original
                    updateVolunteerById(id, dbSanitize(to), 1, function(callback) {
                        getNameById(id, function(callback) {
                            toastr.success(callback + ' has been successfully <strong>copied</strong> to ' + to);
                        });
                    });
                });

                $("#switch-btn").click(function() {
                    //Removes the volunteer from their original group
                    updateVolunteerById(id, dbSanitize(from), 0, function(callback) {});

                    //Adds the volunteer to the new group
                    updateVolunteerById(id, dbSanitize(to), 1, function(callback) {
                        getNameById(id, function(callback) {
                            toastr.success(callback + ' has been successfully <strong>switched</strong> to ' + to);
                        });
                    });
                });
            }
        });
        $(".portlet")
            .addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
            .find(".portlet-header")
            .addClass( "ui-widget-header ui-corner-all");
    });


    //Handles the create event form from the modal
    $("#create-event").click(function() {
       //get the input data
       var start = formatDates($("#start-date").val());
       var end = formatDates($("#end-date").val());
       var title = $("#title").val();

        if(start == "" || end == "" || title == "") {
            toastr.error('You must fill out all the event fields!');
        } else {
            //Use js API to create a new event!
            createEvent(start, end, title, 'black', function (response) {
            });
            toastr.success('Successfully created new event!');
        }
    });

    //Handles appending the $ to the money field
    $("#donation_amount").focus(function() {
        $(this).val('$' + $(this).val());
    });


    //Handles showing the calendar with events
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
        },
        defaultDate: '2016-9-12',
        theme: true,
        navLinks: true,
        editable: true,
        eventLimit: true,
        eventSources: [
            {
                url: '/api/v1/events',
                color: 'blue',
                textColor: 'black'
            }
            // any other sources...

        ]
    });

});

//formats a date from dd/mm/yyy to yyyy-m-d
function formatDates(date) {
    var d = date.split('/');
    var month = d[0];
    var day = d[1];
    var year = d[2];

    return year + '-' + month + "-" + day;
}

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
