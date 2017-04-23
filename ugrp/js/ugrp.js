 // URL String
root     = "http://www.cis355.com/";
userName = "alpero/";
app      = "ugrp/";
URL      = root + userName + app;
jsonURL  = URL + "json.php?event_type=";

// Returns an array grouped by key
var groupBy = function(xs, key) {
  return xs.reduce(function(rv, x) {
    (rv[x[key]] = rv[x[key]] || []).push(x);
    return rv;
  }, {});
};

// Converts 24 hour time to 12 hour time
var time = function (time24){
    var tmpArr = time24.split(':'), time12;
    if(+tmpArr[0] == 12) {
        time12 = tmpArr[0] + ':' + tmpArr[1] + ' pm';
    } else {
        if(+tmpArr[0] == 00) {
            time12 = '12:' + tmpArr[1] + ' am';
        } else {
            if(+tmpArr[0] > 12) {
                time12 = (+tmpArr[0]-12) + ':' + tmpArr[1] + ' pm';
            } else {
                time12 = (+tmpArr[0]) + ':' + tmpArr[1] + ' am';
            }
        }
    }
    return time12;
}

// Converts 24 hour time to 12 hour time but always displays 00 minutes
var hour = function (time24) {
        var tmpArr = time24.split(':'), time12;
    if(+tmpArr[0] == 12) {
        time12 = tmpArr[0] + ':00 pm';
    } else {
        if(+tmpArr[0] == 00) {
            time12 = '12:00 am';
        } else {
            if(+tmpArr[0] > 12) {
                time12 = (+tmpArr[0]-12) + ':00 pm';
            } else {
                time12 = (+tmpArr[0]) + ':00 am';
            }
        }
    }
    return time12;
}

// Array of Event IDs in local storage
var eventsArr = function(arr, key) {
    var json = localStorage.getItem(key);
    var arr  = new Array();
    
    // if localStorage is not empty...
    if (typeof json !== 'undefined' && json !== null && json !== "") {
        // populate array
        var parsed = JSON.parse(json);
        for(var x in parsed){
            arr.push(parsed[x]);
        }
    } 
    return arr;
}

// Adds an event to the list of events in the local storage,
// or removes the event if already in the list.
function myEvents(eventID, dateID, type) { 
    var key = "events";
    var arr = eventsArr(new Array(), key);
    eventID = parseInt(eventID);
    if ($.inArray(eventID, arr) !== -1) { 
        arr.splice($.inArray(eventID, arr),1);
        localStorage.setItem(key, JSON.stringify(arr));
    } else { 
        if (typeof eventID !== 'undefined' && eventID !== null && eventID !== "") arr.push(eventID);
        arr.sort();
        arr = jQuery.unique(arr);
        localStorage.setItem(key, JSON.stringify(arr));
    }    
    displaySchedule(dateID, type);
}

// Sets the icon in Schedule's ListView line item
function setIcon(eventID) {
    var arr  = eventsArr(new Array(), "events");
    eventID = parseInt(eventID);
    if ($.inArray(eventID, arr) !== -1) {
        $str = "data-collapsed-icon='check' data-expanded-icon='check'";
    } else {
        $str = "data-collapsed-icon='plus' data-expanded-icon='plus'";
    }
    return $str;
}

// Sets the text for the myEvents button
function setBtnText(eventID) {
    var arr  = eventsArr(new Array(), "events");
    eventID = parseInt(eventID);
    if ($.inArray(eventID, arr) !== -1) {
        return "Remove from MySchedule";
    } else {
        return "Add to MySchedule";
    }
}

// Builds and returns the Schedule List View
function buildScheduleList(arr, dateID, type) {
    var keys = Object.keys(arr);
    keys.sort();
    var str = "<div id='#collapsibleSet' data-role='collapsible-set' data-inset='false' style='margin:0 !important;'>";
    var hourStr = "";
    for (var x = 0; x < keys.length; x++) {
        var newHour = hour(keys[x]);
        if (newHour != hourStr) {
            hourStr = newHour;
            str += 
                '<div data-role="list-divider" style="background-color:#C25150; line-height:2em; text-shadow: none">' + 
                    '<span style="font-weight:bold; color:#ffffff !important;">&nbsp;&nbsp;&nbsp;' + hourStr + '</span>' + 
                '</div>';
        }
        for (var y = 0; y < arr[keys[x]].length; y++) {
            var id = arr[keys[x]][y].id;
            str += 
                "<div data-role='collapsible' data-collapsed='true' data-iconpos='right' data-inset='false' " +
                setIcon(id) + " style='margin:0 !important;'>" + 
                    "<h3>" +
                        "<div style='display:inline-block; vertical-align:top; text-align:right; margin-right:1vw; max-width:20%; white-space:normal;'>" + 
                                "<span>" + time(arr[keys[x]][y].start_time) + "</span><br />" + 
                                "<span style='color:#aaaaaa'>" + time(arr[keys[x]][y].end_time) + "</span>" + 
                        "</div>" + 
                        "<div style='display:inline-block; vertical-align:top; padding-left:1vw; border-left: solid #dddddd; max-width:75%; white-space:normal;'>" +
                            "<div>" + arr[keys[x]][y].title + "</div>" +
                            "<div class='ui-icon-location ui-btn-icon-notext' style='display:inline-block; position:relative; vertical-align:middle;'></div>" + 
                            "<div style='display:inline; color:#aaaaaa'>" + arr[keys[x]][y].location + "</div>" + 
                        "</div>" +
                    "</h3>" + 
                    "<p>" +
                        "<div>" + arr[keys[x]][y].description + "</div>" + 
                        "<div data-inset='false' style=''><button onClick=myEvents('" + id + "','" + dateID + "','" + type + "')>" + setBtnText(id) + "</button></div>" +
                    "</p>" +
                "</div>";
        }
    }
    return str;
}

// 
function buildList(arr, loc) {
    var str = "";
    for (var i = 0; i < Object.keys(arr).length; i++) {
        str += "<div data-role='collapsible' data-collapsed='true' data-collapsed-icon='false' data-expanded-icon='false'>" +
            "<h3>" + arr[i].title + "<br /><span style='color:#aaaaaa'>" + arr[i].presenters + "</span></h3><p>";
        if (loc == true) {
            str += "<div class='ui-icon-location ui-btn-icon-notext' style='display:inline-block; position:relative; vertical-align:middle;'></div>" +
                "<span style='color:#777777; font-weight: bold;'>LOCATION: </span>" + arr[i].location + "<hr>";
        }
        str += arr[i].description + "</p></div>";
    }
    return str;
}

// Display all queries that contain the submitted substring. 
function displaySearchResults(searchFor) {
    var eventArr = new Array();
    var posterArr = new Array();
    var paperArr = new Array();
    var performancesArr = new Array();
    var str = "<div data-role='collapsible-set' data-inset='false' style='margin:0 !important'>";
    jQuery.ajaxSetup({async:false});    
    $.get(jsonURL + "schedule"    + "&search=" + searchFor, function(data) { eventArr        = JSON.parse(data); });
    $.get(jsonURL + "poster"      + "&search=" + searchFor, function(data) { posterArr       = JSON.parse(data); });
    $.get(jsonURL + "paper"       + "&search=" + searchFor, function(data) { paperArr        = JSON.parse(data); });
    $.get(jsonURL + "performance" + "&search=" + searchFor, function(data) { performancesArr = JSON.parse(data); });    
    if (eventArr.length > 0) {
        str += '<div data-role="list-divider" style="background-color:#C25150; line-height:2em; text-shadow:none">' + 
        '<span style="font-weight:bold; color:#ffffff !important;">&nbsp;&nbsp;&nbsp;Events</span></div>';
        str += buildList(eventArr,false);
    }
    if (posterArr.length > 0) {
        str += '<div data-role="list-divider" style="background-color:#C25150; line-height:2em; text-shadow:none">' + 
        '<span style="font-weight:bold; color:#ffffff !important;">&nbsp;&nbsp;&nbsp;Posters</span></div>';
        str += buildList(posterArr,false);
    }
    if (paperArr.length > 0) {
        str += '<div data-role="list-divider" style="background-color:#C25150; line-height:2em; text-shadow:none">' + 
        '<span style="font-weight:bold; color:#ffffff !important;">&nbsp;&nbsp;&nbsp;Papers</span></div>';
        str += buildList(paperArr,true);
    }
    if (performancesArr.length > 0) {
        str += '<div data-role="list-divider" style="background-color:#C25150; line-height:2em; text-shadow:none">' + 
        '<span style="font-weight:bold; color:#ffffff !important;">&nbsp;&nbsp;&nbsp;Performances</span></div>';
        str += buildList(performancesArr,true);
    }
    if ((eventArr.length == 0) && (posterArr.length == 0) && (paperArr.length == 0) && (paperArr.length == 0)) {
        str += '<p>No Records</p>';
    }
    str += "</div>";
    $('#body').addClass('no-padding');
    $('#body').empty().append(str);
    $('#body').trigger('create');
}

// Append Schedule ListView to the body
function displaySchedule(dateID, type) {
    $.get(jsonURL + "schedule", function ( data ) {
        var arr = JSON.parse(data);
        var str = "";
        if (type == "mySchedule") {
            var myArr = new Array();
            var myEvents = eventsArr(new Array(), "events");
            for (var x = 0; x < arr.length; x++) {
                if ($.inArray(parseInt(arr[x].id), myEvents) !== -1) {
                    myArr.push(arr[x]);
                }
            }
            arr = myArr;
        }
        if (arr.length > 0) {
            var dateArr = groupBy(arr, 'event_date');
            var dates = Object.keys(dateArr);
            str = '<select onChange="displaySchedule(this.options[this.selectedIndex].value,\'' + type + '\');">';
            for (var x = 0; x < dates.length; x++) {
                str += '<option value=' + x;
                if (x == dateID) str += ' selected';
                var utc = new Date(Date.UTC(dates[x].split('-')[0], dates[x].split('-')[1]-1, dates[x].split('-')[2], 5, 0, 0));
                str += '>' + $.format.date(utc, "E, MMM D yyyy")  + '</option>';
            }
            str += '</select>';
            str += buildScheduleList(groupBy(dateArr[dates[dateID]], 'start_time'), dateID, type);
        } else {
            str += "<p>No Records</p>";
        }
        $('#body').addClass('no-padding');
        $('#body').empty().append(str);
        $('#body').trigger('create');
    });
}

// Display the specified list
function displayList(type) {
    $.get(jsonURL + type, function( data ) {
        var arr = JSON.parse(data);
        var str = "<div data-role='collapsible-set' data-inset='false' style='margin:0 !important'>";
        str += (type != "poster") ? buildList(arr, true) : buildList(arr, false);
        str += "</div>";
        $('#body').removeClass('no-padding');
        $('#body').empty().append(str);
        $('#body').trigger('create');
    });
}

// Display Map
function displayMap(map) {
    var imgFile = "map.png";
    var str = "<img src='img/" + imgFile + "' width='100%' height='auto'>";
    $('#body').addClass('no-padding');
    $('#body').empty().append(str);
    $('#body').trigger('create');
}