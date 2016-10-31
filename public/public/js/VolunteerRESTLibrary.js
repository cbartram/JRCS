/**
 * Created by christian bartram on 9/22/16.
 * Not really sure how to name this file but
 * it contains methods to query and parse volunteer info
 */
var baseURL     = "api/v1/volunteers";
var eventURL    = "api/v1/events";
var donationURL = "api/v1/donations";
var authURL     = "api/v1/authenticate";


/**
 * Handles Authenticating a staff member with the system
 * Returns true if the email and password are correct and false otherwise
 * @param email Staff members email
 * @param password staff members Un-Hashed password
 * @param getResult Callback function for getting a response
 */
function authenticate(email, password, getResult) {
    $.post(authURL, {email:email, password:password}, function(data) {
        getResult(data);
    }, "json");
}



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
 * Gets a volunteers first name and last name given their id
 * @param id volunteers id
 * @param getResult callback function for getting the response
 */
function getNameById(id, getResult) {
    $.ajax({
        type: 'GET',
        url: baseURL + "/id/" + id,
        dataType: "json",// data type of response
        success: function (data) {
            var name = data.first_name + " " + data.last_name;
            getResult(name)
        }
    });
}

/**
 * Gets a volunteers first name and last name given their email
 * @param email volunteers email
 * @param getResult callback function for getting the response
 */
function getNameByEmail(email, getResult) {
    $.ajax({
        type: 'GET',
        url: baseURL + "/email/" + email,
        dataType: "json",// data type of response
        success: function (data) {
            var name = data.first_name + " " + data.last_name;
            getResult(name)
        }
    });
}

/**
 * Gets a volunteers id given their email
 * @param email volunteers email
 * @param getResult callback function
 */
function getId(email, getResult) {
    $.ajax({
        type: 'GET',
        url: baseURL + "/email/" + email,
        dataType: "json",// data type of response
        success: function (data) {
            getResult(data.id)
        }
    });
}

/**
 * Gets a volunteers email given their id
 * @param id volunteers id
 * @param getResult callback function
 */
function getEmail(id, getResult) {
    $.ajax({
        type: 'GET',
        url: baseURL + "/id/" + id,
        dataType: "json",// data type of response
        success: function (data) {
            getResult(data.email)
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

/**
 * Deletes a volunteer given the volunteers id and a callback function
 * @param id volunteers id
 * @param getResult callback function
 */
function deleteVolunteerById(id, getResult) {
    var settings = {
        "async": true,
        "crossDomain": true,
        "url": "http://jrcs.herokuapp.com/api/v1/volunteers/id/" + id,
        "method": "DELETE",
        "headers": {
            "cache-control": "no-cache"
        }
    };

    $.ajax(settings).done(function (response) {
        getResult(response);
    });
}
/**
 * Deletes a volunteer given the volunteers email and a callback function
 * @param email volunteers email
 * @param getResult callback function
 */
function deleteVolunteerByEmail(email, getResult) {
    var settings = {
        "async": true,
        "crossDomain": true,
        "url": "http://jrcs.herokuapp.com/api/v1/volunteers/email/" + email,
        "method": "DELETE",
        "headers": {
            "cache-control": "no-cache"
        }
    };

    $.ajax(settings).done(function (response) {
        getResult(response);
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
    var settings = {
        "async": true,
        "crossDomain": true,
        "url": "http://jrcs.herokuapp.com/api/v1/volunteers/id/" + id + "/" + column + "/" + value,
        "method": "PATCH",
        "headers": {
            "cache-control": "no-cache",
            "content-type": "application/x-www-form-urlencoded"
        }
    };

    $.ajax(settings).done(function (response) {
        getResult(response);
    });
}

/**
 * Updates one column with a given value given the volunteers id
 * @param id volunteer email
 * @param column column to update
 * @param value value to update the column with
 * @param getResult callback function
 */
function updateVolunteerByIdTest(id, column, value, getResult) {
    var settings = {
        "async": true,
        "crossDomain": true,
        "url": "http://localhost:8000/api/v1/volunteers/id/" + id + "/" + column + "/" + value,
        "method": "PATCH",
        "headers": {
            "cache-control": "no-cache",
            "content-type": "application/x-www-form-urlencoded"
        }
    };

    $.ajax(settings).done(function (response) {
        getResult(response);
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
    var settings = {
        "async": true,
        "crossDomain": true,
        "url": "http://jrcs.herokuapp.com/api/v1/volunteers/email/" + email + "/" + column + "/" + value,
        "method": "PATCH",
        "headers": {
            "cache-control": "no-cache",
            "content-type": "application/x-www-form-urlencoded"
        }
    };

    $.ajax(settings).done(function (response) {
        getResult(response);
    });
}

/**
 * Updates one column with a given value given the volunteers email
 * @param email volunteers email
 * @param column column to update
 * @param value value to update the column with
 * @param getResult callback function
 */
function updateVolunteerByEmailTest(email, column, value, getResult) {
    var settings = {
        "async": true,
        "crossDomain": true,
        "url": "http://localhost:8000/api/v1/volunteers/email/" + email + "/" + column + "/" + value,
        "method": "PATCH",
        "headers": {
            "cache-control": "no-cache",
            "content-type": "application/x-www-form-urlencoded"
        }
    };

    $.ajax(settings).done(function (response) {
        getResult(response);
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

/**
 * #######################################
 * CICO Methods
 * #######################################
 */

/**
 * Checks a volunteer into the system (Check-in) given the following parameters
 * @param email volunteers email
 * @param type volunteer type (general program board)
 * @param program program (if type is program, act, sat prep etc...)
 * @param getResult callback function to return the result in the console.
 */
function checkIn(email, type, program, getResult) {
    $.post('http://localhost:8000/cico', {email: email, type: type, program: program}).done(function (response) {
        getResult(response);
    });
}


/**
 * Checks a volunteer out of the system (Check-out) given the following parameters
 * @param email volunteers email
 * @param getResult callback function to return the result in the console.
 */
function checkOut(email, getResult) {
    $.post('http://localhost:8000/checkout', {email: email}).done(function (response) {
        getResult(response);
    });
}

/**
 * #######################################
 * Event Methods
 * #######################################
 */

/**
 * Returns all Calendar events in the Database
 * @param getResult callback function
 */
function getAllEvents(getResult) {
    $.ajax({
        type: 'GET',
        url: eventURL,
        dataType: "json",
        success: function (data) {
           getResult(data);
        }
    });
}

/**
 * Returns a specific event given the events id
 * @param id Event Id
 * @param getResult callback function
 */
function getEventById(id, getResult) {
    $.ajax({
        type: 'GET',
        url: eventURL + "/" + id,
        dataType: "json",
        success: function (data) {
            getResult(data);
        }
    });
}

/**
 * Creates a new calendar event
 * @param start start date in yyyy-m-d format
 * @param end end date in yyyy-m-d format
 * @param title Title (spaces will be replaced with underscores)
 * @param color Color of the event in the calendar
 * @param group Group the Event belongs to (JACO, BEBCO, JBC)
 * @param getResult callback function
 */
function createEvent(start, end, title, color, group, getResult) {
    title = title.replace(' ', '_');
    $.ajax({
        type: 'GET',
        url: eventURL + "/create/" + start + "/" + end + "/" + title + "/" + color + "/" + group,
        dataType: "json",
        success: function (data) {
            getResult(data);
        }
    });
}

/**
 * Deletes an event from the calendar given the id returns 1 if the deletion was successful 0 otherwise
 * @param id the id of the event to delete
 * @param getResult callback function to recieve a response.
 */
function deleteEvent(id, getResult) {
    $.ajax({
        type: 'GET',
        url: eventURL + "/delete/" + id,
        dataType: "json",
        success: function (data) {
            getResult(data);
        }
    });
}

/**
 * #######################################
 * Donation Methods
 * #######################################
 */

/**
 * Re-Opens a previously closed donation
 * @param id Donation ID
 * @param getResult callback function
 */
function openDonation(id, getResult) {
    $.ajax({
        type: 'GET',
        url: '../' + donationURL + "/open/" + id,
        dataType: "json",
        success: function (data) {
            getResult(data);
        }
    });
}

/**
 * Denies a pending donation request
 * @param id Donation id
 * @param getResult callback function
 */
function denyDonation(id, getResult) {
    $.ajax({
        type: 'GET',
        url:  donationURL + "/deny/" + id,
        dataType: "json",
        success: function (data) {
            getResult(data);
        }
    });
}

/**
 * Approves a pending donation request
 * @param id Donation id
 * @param getResult callback function
 */
function approveDonation(id, getResult) {
    $.ajax({
        type: 'GET',
        url:  donationURL + "/approve/" + id,
        dataType: "json",
        success: function (data) {
            getResult(data);
        }
    });
}





