/**
 * Created by christianbartram on 9/22/16.
 * Not really sure how to name this file but
 * it contains methods to query and parse volunteer info
 */
var baseURL = "../../application/REST/api/Rest_Controller.php/volunteers";

function getAllVolunteers(getResult) {
    $.ajax({
        type: 'GET',
        url: baseURL,
        dataType: "json",// data type of response
        success: function (data) {
            //do what you want with the data can be accessed at data.volunteers[0].whatever_column
            getResult(data);
        }
    });
}


function getVolunteerById(id, getResult) {
    $.ajax({
        type: 'GET',
        url: baseURL,
        dataType: "json",// data type of response
        success: function (data) {
            for(var i = 0; i < data.volunteers.length; i++) {
                if(data.volunteers[i].volunteer_id == id) {
                    console.log("Found the ID " + id + ' in the JSON object ' + data.volunteers[i]);
                    getResult(data.volunteers[i]);
                }
            }
        }
    });
}


function getVolunteerByEmail(email, getResult) {
    $.ajax({
        type: 'GET',
        url: baseURL,
        dataType: "json",
        success: function (data) {
            for(var i = 0; i < data.volunteers.length; i++) {
                if(data.volunteers[i].email == email) {
                    console.log("Found the Email " + email + ' in the JSON object ' + data.volunteers[i]);
                    //Callback function to return data from the asynchronous call
                    getResult(data.volunteers[i]);
                }
            }
        }
    });
}


function getNameById(id, getResult) {
    $.ajax({
        type: 'GET',
        url: baseURL,
        dataType: "json",
        success: function (data) {
            for(var i = 0; i < data.volunteers.length; i++) {
                if(data.volunteers[i].id == id) {
                    var name = data.volunteers[i].first_name + " " + data.volunteers[i].last_name;
                    getResult(name);
                }
            }
        }
    });
}
