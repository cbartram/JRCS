/**
 * Created by christian bartram on 9/22/16.
 * Not really sure how to name this file but
 * it contains methods to query and parse volunteer info
 */
var baseURL = "../../application/REST/api/Rest_Controller.php/volunteers";

/**
 * Returns all volunteers in the system as a JSON object data for a specific
 * volunteer can be accessed using 'data.volunteers[index].attribute_name'
 * @param getResult callback function used to get the results from the asynch ajax call
 */
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

/**
 * Returns one specific volunteer in the system as a JSON object data for a specific
 * volunteer can be accessed using 'data.volunteers[index].attribute_name'
 * @param getResult callback function used to get the results from the asynch ajax call
 * @param id The `volunteer_id`
 */
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


/**
 * Returns one specific volunteer in the system as a JSON object data for a specific
 * volunteer can be accessed using 'data.volunteers[index].attribute_name'
 * @param getResult callback function used to get the results from the asynch ajax call
 * @param email The volunteers email
 */
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


/**
 * Returns the first name and last name of one specific volunteer in the system as a JSON object data for a specific
 * volunteer can be accessed using 'data.volunteers[index].attribute_name'
 * @param getResult callback function used to get the results from the asynch ajax call
 * @param id The `volunteer_id`
 */
function getVolunteerNameById(id, getResult) {
    $.ajax({
        type: 'GET',
        url: baseURL,
        dataType: "json",
        success: function (data) {
            for(var i = 0; i < data.volunteers.length; i++) {
                if(data.volunteers[i].id == id) {
                    var name = data.volunteers[i].first_name + " " + data.volunteers[i].last_name;
                    getResult(data.volunteers[i]);
                }
            }
        }
    });
}


/**
 * Returns the first name and last name of one specific volunteer in the system as a JSON object data for a specific
 * volunteer can be accessed using 'data.volunteers[index].attribute_name'
 * @param getResult callback function used to get the results from the asynch ajax call
 * @param email The volunteers email
 */
function getVolunteerNameByEmail(email, getResult) {
    $.ajax({
        type: 'GET',
        url: baseURL,
        dataType: "json",
        success: function (data) {
            for(var i = 0; i < data.volunteers.length; i++) {
                if(data.volunteers[i].email == email) {
                    var name = data.volunteers[i].first_name + " " + data.volunteers[i].last_name;
                    getResult(name);
                }
            }
        }
    });
}

/**
 * Returns true if the volunteers is part of the bebco group false otherwise
 * @param email the volunteers email
 * @param getResult callback function used to get the results from the asynch ajax call
 */
function isBebcoVolunteer(email, getResult) {
    $.ajax({
        type: 'GET',
        url: baseURL,
        dataType: "json",
        success: function (data) {
            for(var i = 0; i < data.volunteers.length; i++) {
                if(data.volunteers[i].email == email) {
                    if(data.volunteers[i].bebco_volunteer == "1") {
                        getResult(true);
                    } else {
                        getResult(false);
                    }
                }
            }
        }
    });
}

/**
 * Returns true if the volunteers is part of the jaco group false otherwise
 * @param email the volunteers email
 * @param getResult callback function used to get the results from the asynch ajax call
 */
function isJACOVolunteer(email, getResult) {
    $.ajax({
        type: 'GET',
        url: baseURL,
        dataType: "json",
        success: function (data) {
            for(var i = 0; i < data.volunteers.length; i++) {
                if(data.volunteers[i].email == email) {
                    if(data.volunteers[i].jaco_volunteer == "1") {
                        getResult(true);
                    } else {
                        getResult(false);
                    }
                }
            }
        }
    });
}

/**
 * Returns true if the volunteers is part of the jbc group false otherwise
 * @param email the volunteers email
 * @param getResult callback function used to get the results from the asynch ajax call
 */
function isJBCVolunteer(email, getResult) {
    $.ajax({
        type: 'GET',
        url: baseURL,
        dataType: "json",
        success: function (data) {
            for(var i = 0; i < data.volunteers.length; i++) {
                if(data.volunteers[i].email == email) {
                    if(data.volunteers[i].jbc_volunteer == "1") {
                        getResult(true);
                    } else {
                        getResult(false);
                    }
                }
            }
        }
    });
}

/**
 * Returns the authentication level attribute for a single volunteer
 * in the system given the volunteers email
 * @param email the volunteers email
 * @param getResult callback function used to get the results from the asynch ajax call
 */
function getVolunteerAuthenticationLevel(email, getResult) {
    $.ajax({
        type: 'GET',
        url: baseURL,
        dataType: "json",
        success: function (data) {
            for(var i = 0; i < data.volunteers.length; i++) {
                if(data.volunteers[i].email == email) {
                    getResult(data.volunteers[i].authentication_level);
                }
            }
        }
    });
}

