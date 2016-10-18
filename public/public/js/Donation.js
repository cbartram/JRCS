/**
 * Created by christianbartram on 10/18/16.
 */
$(document).ready(function() {
    //Hide specific fields on page load (not monetary because thats the default)
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