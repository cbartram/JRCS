/**
 * Created by christianbartram on 11/22/16.
 */
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