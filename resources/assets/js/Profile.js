/**
 * Created by christianbartram on 9/16/16.
 */

$(document).ready(function() {
    var text = $("#current-group").html();
    var currentGroup = text.substring(8, text.length);

    //Holds array of id's the staff member wishes to remove from the system
    var deleteArray = [];

    $('.fa-minus').click(function() {
        $(this).parent().next().slideToggle("slow");
        $(this).toggleClass('fa-plus fa-minus');
    });

    $('#hide-all').click(function() {
        //for each panel body on the page
       $('.panel-body').each(function() {
          $(this).slideToggle("slow");
       });
    });



    $("#volunteers, #checkbox-access, #password, #staff").hide();
    //promote on click show volunteers, checkbox-access, password
    $("#promote").find('input').change(function() {
        $("#staff").hide("slow");
        $("#volunteers, #checkbox-access, #password").show("slow");
    });


    $("#demote").find('input').change(function() {
        $("#volunteers, #checkbox-access, #password").hide("slow");
       $("#staff").show("slow");

    });

    //Handles getting the Donation ID from a donation denied request
    $('.fa-thumbs-o-down').parent().click(function() {
       var donationID = $(this).parent().siblings(":first").text();
        $("#donation-denied-form").attr('action', "/donation/deny/" + donationID);
    });

    //Handles
    $(".btn-success").click(function() {
        //Travels up the DOM searching for H4 tag with the CSS class user-name could be done better
        var user = $(this).parent().parent().parent().parent().find('.user-name').text();

        var element = $(this).parent().parent().parent().find(".vol-id").text();
        var id = element.substr(element.length - 12, element.length);

        getVolunteerById(id, function(output) {

            //Load the volunteer profile details
            $("#table-body").append('<tr><td>'
                + output.first_name + '</td><td>'
                + output.last_name + '</td><td class="vol-id">'
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

        $("#modal-title").html(user.substr(0, user.indexOf('-') - 1) + "'s Volunteer Details");

    });



    //start of the editable table plugin integration for upating event logs
    $('.table-striped').Tabledit({
        url: '/api/v1/log/update',
        editButton: false,
        deleteButton: false,
        hideIdentifier: true,
        columns: {
            identifier: [0, 'event_id'],
            editable: [
                [1, 'title'],
                [2, 'start_date'],
                [3, 'attendee_count'],
                [4, 'volunteer_count'],
                [5, 'total_volunteer_hours'],
                [6, 'donation_amount']
            ]
        },
        onAjax: function() {
            //when an ajax request is sent
            toastr.info('Attempting to update information...');
            console.log(this.url);
        },
        onSuccess: function(data, textStatus, jqXHR) {
            console.log(data);
            if (data == false) {
                toastr.error('Uh oh, Your updates could not be saved! Ensure that your date is in the format YYYY-MM-DD and all other values are numeric!');
            } else {
                toastr.success('Your event log updates have been saved successfully!');
            }
        }
    });

    //Add Date pickers from jqueryUI to date selectors
    $("#start-date, #end-date, #export-start-date, #export-end-date").datepicker();
    $("#export-start-date, #export-end-date").datepicker("option", "dateFormat", 'yy-mm-dd');

    //Handles emptying the trash!
    $("#delete").click(function() {
       for(var i = 0; i < deleteArray.length; i++) {
           archiveVolunteerById(deleteArray[i], function(callback) {
               window.location.reload();
               toastr.success("Volunteer has been <strong>archived</strong> successfully!");
           });

       }
    });

    //handles archiving a volunteer through the REST API
    $("#archive-volunteer").click(function() {
        var id = $(this).parent().parent().parent().prev().find('.vol-id').text();

        //Archive the volunteer
        archiveVolunteerById(id, function(response) {
            console.log(response);

            if(response == "true") {
                $("#myModal").modal('toggle');
                toastr.success('Successfully Archived Volunteer: ' + id);
            } else {
                $("#myModal").modal('toggle');
                toastr.error('Failed to Archive Volunteer, make sure their profile is fully loaded before you try to archive them!');
            }

        });
    });

    //Pusher code
    var pusher = new Pusher('2b625b4ec56b59013e86', {
        encrypted: true
    });

    var channel = pusher.subscribe('test-channel');

channel.bind('test-event', function(data) {
    console.log(data);

        //If the person who the message is for is the currently logged in user
        getAuthenticatedUser(function(user) {
            if(data.to === user.id) {
                //Show the message and update the badge
                toastr.success('New Message From: ' + data.name);

                var notification = parseInt($('.notif-count').text());

                //Get the notification count currently
                $('.notif-count').text(notification + 1);

                //Append a new notification to the dropdown till a page refresh occurs and PHP takes over
                $('#notification-dropdown').append('<li><a href="#">' +
                    '<span class="badge" style="background-color:red">New</span> <b>' + data.name + '</b> says <b>' + data.text + '</b></a></li>')
            }

        });
});


    //Handles getting necessary data from the clicked notification to the modal
    $('.notification-link').click(function() {
        $('#notification-reply-modal').modal('show');

        //Get data from element attributes
        var notificationID = $(this).attr('data-id');
        var name = $(this).attr('data-name');
        var message = $(this).attr('data-message');
        var from = $(this).attr('data-from');
        var gravatar = $(this).find('img').attr('src');

        //Apply the data to the modal
        $('#notification-reply-header').text('Message from ' + name);
        $('.notification-reply-message').text(message);
        $('.notification-reply-delete').attr('href', '/notification/remove/' + notificationID);
        $('.notification-reply-read').attr('href', '/notification/read/' + notificationID);
        $('.notification-reply-picture').attr('src', gravatar);
    });

    $('.notification-reply-reply').click(function() {
       $('#notification-reply-modal').modal('toggle');
        $("#notification-modal").modal('show');
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
       var group = $("#group-select").val();

        if(start == "" || title == "") {
            toastr.error('You must fill out both the start date and the title fields!');
        } else {

            //if the user does not specify an end date default it to be the start date
            if(end == "") {
                end = start;
            }

            var color;

            switch(group) {
                case "JACO":
                    color = "e7984e";
                    break;
                case "BEBCO":
                    color = "b40a30";
                    break;
                case "JBC":
                    color = "4880d1";
                    break;
                case "JRCS":
                    color = "6abb62";
                    break;
                default:
                    color = "black"
            }

            //Use js API to create a new event!
            createEvent(start, end, title, color, group, function (response) {
            });
            toastr.success('Successfully created new event!');
        }
    });


    //Handles appending the $ to the money field
    $("#donation_amount").focus(function() {
        $(this).val('$' + $(this).val());
    });


    if(currentGroup == "ADMIN") {
        //Handles showing the calendar with events
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'
            },
            defaultDate: moment(),
            navLinks: false, // can click day/week names to navigate views and see events for a particular day
            editable: false, //can drag and drop events onto different days todo this is a bug right now
            eventLimit: true, // allow "more" link when too many events
            eventSources: [
                {
                    url: '/api/v1/events'
                }

            ]
        });

    } else {

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next,today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'
            },
            defaultDate: moment(),
            navLinks: false, // can click day/week names to navigate views and see events for a particular day
            editable: true, //can drag and drop events onto different days todo this is a bug right now
            eventLimit: true,
            eventSources: [
                {
                    url: '/api/v1/events/' + currentGroup
                }

            ]
        });
    }

    //Handles showing the previous and next months and today
    $('#prev').click(function() {
       $("#calendar").fullCalendar('prev');
    });

    $("#next").click(function() {
       $("#calendar").fullCalendar('next');
    });

    $("#today").click(function() {
        $("#calendar").fullCalendar('today');
        toastr.info('Loading Calendar Events....');
    });

    $("#date-btn").click(function() {
       var date = $('#goToDate').val();
        if(moment(date, 'MM/DD/YYYY', true).isValid() || moment(date, 'MM-DD-YYYY', true).isValid()) {
            $('#calendar').fullCalendar('gotoDate', date);
        } else {
            toastr.error("Your date format is incorrect make sure its in the format: MM/DD/YYYY");
        }
    });


    //Handles Donation made by staff
    $("#type").hide();
    $("#inkind").hide();

    $("#donation-type").change(function() {
        //gets the selected attribute from the option list
        var type = $(this).find(':selected').attr('name');

        switch(type) {
            case 'monetary':
                $("#amount").show();
                $("#type").hide();
                $("#inkind").hide();
                break;
            case 'supplies':
                $("#amount").hide();
                $("#type").show();
                $("#inkind").hide();
                break;
            case 'inkind':
                $("#amount").hide();
                $("#type").hide();
                $("#inkind").show();
                break;
        }
    });

    //Handles appending the $ to the money field
    $("#amount").focus(function() {
        $(this).val('$' + $(this).val());
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
