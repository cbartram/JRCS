/**
 * Created by christianbartram on 11/22/16.
 */
$(document).ready(function() {

    $(".btn-save, .btn-cancel").hide();

    //If the DOM already has a open row for a new timestamp dont add a new one
    var name = $('.name').first().text();
    var email = $('.email').first().text();

    //Handles when an additional CICO time is manually added to this volunteer
    $('.btn-circle').click(function() {

        //The input forms will be submitted via an ajax request
        $('#detail-cico-table tr:last').after('<tr>' +
            '<td><select class="form-control" id="volunteer-type"><option value="General">General</option>' +
            '<option value="Program">Program</option><option value="board">Board</option></select></td>' +
            '<td><select class="form-control" id="for-group"><option value="BEBCO">BEBCO</option><option value="JACO">JACO</option>' +
            '<option value="JBC">JBC</option><option value="JRCS">JRCS</option></select></td>' +
            '<td><input type="text" class="form-control check-in" id="checkin" placeholder="Check-In Timestamp"></td>' +
            '<td><input type="text" placeholder="Check-Out Timestamp" id="checkout" class="form-control"></td>' +
            '</tr>');

        //Show and hide the correct buttons
        $(this).hide();
        $(".btn-save, .btn-cancel").show('slow');


    });


    $(".btn-save").click(function() {
        var checkin  = $("#checkin");
        var checkout = $("#checkout");
        var type = $("#volunteer-type").val();
        var forGroup = $("#for-group").val();
        var checkIn = $("#checkin").val();
        var checkOut = $("#checkout").val();

        //If there is nothing in the input boxes
        if(!checkin.val() || !checkout.val()) {
            toastr.error('Make sure you enter information in before saving it!');
        } else {
            //Make the ajax request
            $.ajax({

                url:"/cico/save",
                type:"get",
                dataType:"json",
                data:{email:email, type:type, group:forGroup, checkIn:checkIn, checkOut:checkOut}

            }).done(function(response) {
                if(response === false) {
                   toastr.error('Your Timestamps must be in the format YYYY-MM-DD HH:MM AM/PM');
                } else {
                    toastr.success('Successfully Added new timestamp for ' + email + "!")
                }
            });
        }

    });

    //The cancel button click action
    $(".btn-cancel").click(function() {

        $(".btn-save, .btn-cancel").hide();
        $('.btn-circle').show('slow');

        $("#detail-cico-table tr:last").remove();

    });
});


//start of the editable table plugin integration
$('.volunteer').Tabledit({
    url: '/api/v1/demographics/update',
    editButton: false,
    deleteButton: false,
    hideIdentifier: false,
    columns: {
        identifier: [0, 'id'],
        editable: [
            //todo should the name be editable? I could just change my name to clay and then take credit for his hours etc...
            // [1, 'first_name'],
            // [2, 'last_name'],
            [4, 'phone'],
            [5, 'city'],
            [6, 'state'],
            [7, 'zip_code']
        ]
    },
    onAjax: function() {
        //when an ajax request is sent
        toastr.info('Attempting to update information...');
    },
    onSuccess: function(data, textStatus, jqXHR) {
        console.log(data);
        if (data == false) {
            toastr.error('Uh oh, Your updates could not be saved please try again!');
        } else {
            toastr.success('Your demographic updates have been saved successfully!');
        }
    }
});

$('.table-striped').Tabledit({
    url: '/api/v1/cico/search/update',
    editButton: false,
    deleteButton: false,
    hideIdentifier: true,
    columns: {
        identifier: [0, 'id'],
        editable: [
            [3, 'check_in_timestamp'],
            [4, 'check_out_timestamp']
        ]
    },
    onAjax: function() {
        //when an ajax request is sent
        toastr.info('Attempting to update information...');
    },
    onSuccess: function(data, textStatus, jqXHR) {
        console.log(data);
        if (data == false) {
            toastr.error('Your timestamp must be in the format YYYY-MM-DD H:MM AM/PM Timestamp has not yet been saved.');
        } else {
            toastr.success('Your demographic updates have been saved successfully!');

        }
    }
});
