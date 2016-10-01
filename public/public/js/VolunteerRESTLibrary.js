/**
 * Created by christian bartram on 9/22/16.
 * Not really sure how to name this file but
 * it contains methods to query and parse volunteer info
 */
var baseURL = "api/v1/volunteers";

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
        url: baseURL + "/id/" + id,
        dataType: "json",// data type of response
        success: function (data) {
            getResult(data)
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
        url: baseURL + "/email/" + email,
        dataType: "json",
        success: function (data) {
            getResult(data);
        }
    });
}

//todo next 4 methods havent been tested
/**
 * Deletes a volunteer given the volunteers id and a callback function
 * @param id volunteers id
 * @param getResult callback function
 */
function deleteVolunteerById(id, getResult) {
    $.ajax({
        type: 'DELETE',
        url: baseURL + "/id/" + id,
        dataType: "json",
        success: function(data) {
            getResult(data);
        }
    });
}

/**
 * Deletes a volunteer given the volunteers email and a callback function
 * @param email volunteers email
 * @param getResult callback function
 */
function deleteVolunteerByEmail(email, getResult) {
    $.ajax({
        type: 'DELETE',
        url: baseURL + "/email/" + email,
        dataType: "json",
        success: function(data) {
            getResult(data);
        }
    });
}

/**
 * Updates one column with a given value given the volunteers id
 * @param id volunteer email
 * @param column column to update
 * @param value value to update the column with
 * @param getResult callback function
 */
function updateVolunteerById(id, column, value, getResult) {
    $.ajax({
        url : baseURL + "/id/" + id,
        data : {columnToUpdate: column, newValue: value},
        type : 'PATCH',
        contentType : 'application/json',
        processData: false,
        dataType: 'json',
        success: function(data) {
            getResult(data)
        }
    });
}

/**
 * Updates one column with a given value given the volunteers email
 * @param email volunteers email
 * @param column column to update
 * @param value value to update the column with
 * @param getResult callback function
 */
function updateVolunteerByEmail(email, column, value, getResult) {
    $.ajax({
        url : baseURL + "/email/" + email,
        data : {columnToUpdate: column, newValue: value},
        type : 'PATCH',
        contentType : 'application/json',
        processData: false,
        dataType: 'json',
        success: function(data) {
            getResult(data)
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
        url: baseURL + "/email/" + email,
        dataType: "json",
        success: function (data) {
            if(data.bebco_volunteer == 1) {
                getResult(true)
            } else {
                getResult(false)
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
        url: baseURL + "/email/" + email,
        dataType: "json",
        success: function (data) {
            if(data.jaco_volunteer == 1) {
                getResult(true)
            } else {
                getResult(false)
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
        url: baseURL + "/email/" + email,
        dataType: "json",
        success: function (data) {
            if(data.jbc_volunteer == 1) {
                getResult(true)
            } else {
                getResult(false)
            }
        }
    });
}

