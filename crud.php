<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-2.1.1.js"></script>
    <script>
        // Display the requested form.
        function getForm(request, id) {
            var url = window.location.pathname;
            var filename = url.substring(url.lastIndexOf('/')+1);
            window.location = filename + "?action=" + request + "&id=" + id;
        }
        
        // Submit a form to the server.
        function submitForm(action) {
            var dataString =
                "action="+action+
                "&event_id="+$("#event_id").val()+
                "&event_type="+$("#event_type").val()+
                "&start_time="+$("#start_time").val()+
                "&end_time="+$("#end_time").val()+
                "&event_date="+$("#event_date").val()+
                "&location="+$("#location").val()+
                "&title="+$("#title").val()+
                "&description="+$("#description").val()+
                "&presenters="+$("#presenters").val();
            $.ajax({
                type: "POST",
                url: "crud.php",
                data: dataString
            }).done(function( msg ) {
                window.location.href  = location.protocol + '//' + location.host + location.pathname;
            });
        }
    </script>
    <style>
        .btn {
            width: 75px;
        }
    </style>
</head>
<body>

<?php
    // Display a UI Form if $_GET['action'] is set.
    if(isset($_GET['action'])) { 
        $action = $_GET['action'];
        if($action == "create"  ) createForm();
        if($action == "read"    ) readForm();
        if($action == "update"  ) updateForm();
        if($action == "delete"  ) deleteForm();
    }
    
    // Manipulate the database if $_POST['action'] is set.
    elseif(isset($_POST['action'])) {
        $action = $_POST['action'];
        $sql = "";
        $values = array();
        if($action == "create") {
            $sql = ("INSERT INTO ugrp_events (start_time, end_time, event_date, location, title, description, event_type, presenters) VALUES (?,?,?,?,?,?,?,?)");
            $values = array($_POST['start_time'], $_POST['end_time'], $_POST['event_date'], $_POST['location'], $_POST['title'], $_POST['description'], $_POST['event_type'], $_POST['presenters']);
        }
        if($action == "update") {
            $sql = ("UPDATE ugrp_events SET start_time = ?, end_time = ?, event_date = ?, location = ?, title = ?, description = ?, event_type = ?, presenters = ? WHERE id = ?");
            $values = array($_POST['start_time'], $_POST['end_time'], $_POST['event_date'], $_POST['location'], $_POST['title'], $_POST['description'], $_POST['event_type'], $_POST['presenters'], $_POST['event_id']);
        }
        if($action == "delete") {
            $sql = "DELETE FROM ugrp_events WHERE id = ?";
            $values = array($_POST['event_id']);
        }
        prepare($sql,$values);
    }
    
    // Display the records table if no action is set.
    else { displayTable(); }
    
    /************/
    /* DATABASE */
    /************/
    
    // Return a query from the database.
    function query($sql) {
        require_once("database.php");
        $pdo = Database::connect();
        $q = $pdo->query($sql);
        Database::disconnect();
        return $q;
    }
    
    // Prepares and Executes a SQL command.
    function prepare($sql, $values) {
        require_once("database.php");
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $q = $pdo->prepare($sql);
        $q->execute($values);
        Database::disconnect();
    }
        
    /******************/
    /* USER INTERFACE */
    /******************/
    
    // Display a form for adding a record to the database.
    function createForm() {
        echo '
            <div class="container">
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Create Event</h3>
                    </div>
                    <div class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label">Event Type</label>
                            <div class="controls">
                                <select id="event_type">
                                    <option value="schedule">schedule</option>
                                    <option value="poster">poster</option>
                                    <option value="paper">paper</option>
                                    <option value="performance">performance</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Start Time</label>
                            <div class="controls">
                                <input id="start_time" name="start_time" type="time" value="13:00">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">End Time</label>
                            <div class="controls">
                                <input id="end_time" name="end_time" type="time" VALUE="14:00">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Date</label>
                            <div class="controls">
                                <input id="event_date" name="event_date" type="date" value="2017-04-21">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Location</label>
                            <div class="controls">
                                <input id="location" name="location">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Title</label>
                            <div class="controls">
                                <textarea id="title" name="title"></textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Description</label>
                            <div class="controls">
                                <textarea id="description" name="description"></textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Presenters</label>
                            <div class="controls">
                                <textarea id="presenters" name="presenters"></textarea>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button class="btn btn-success" onClick="submitForm(\'create\');">Create</button>
                            <a class="btn" href="' . basename(__FILE__) . '">Back</a>
                        </div>
                    </div>
                </div>
            </div>';
    }
    
    // Display a form containing information about a specified record in the database.
    function readForm() {
        $q = query("SELECT * FROM ugrp_events WHERE id = " . $_GET['id']);
        $q = $q->fetch(PDO::FETCH_ASSOC);
        echo '
            <div class="container">
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Record Details</h3>
                    </div>                    
                    <div class="form-horizontal" >
                        <div class="control-group">
                            <label class="control-label">Event ID</label>
                            <div class="controls">
                                <label class="checkbox">'
                                    . $q['id'] . 
                                '</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Event Type</label>
                            <div class="controls">
                                <label class="checkbox">'
                                    . $q['event_type'] . 
                                '</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Start Time</label>
                            <div class="controls">
                                <label class="checkbox">'
                                        . $q['start_time'] . 
                                '</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">End Time</label>
                            <div class="controls">
                                <label class="checkbox">'
                                        . $q['end_time'] . 
                                '</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Date</label>
                            <div class="controls">
                                <label class="checkbox">'
                                    . $q['event_date'] . 
                                '</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Location</label>
                            <div class="controls">
                                <label class="checkbox">'
                                    . $q['location'] . 
                                '</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Title</label>
                            <div class="controls">
                                <label class="checkbox">'
                                    . $q['title'] . 
                                '</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Description</label>
                            <div class="controls">
                                <label class="checkbox">'
                                    . $q['description'] . 
                                '</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Presenters</label>
                            <div class="controls">
                                <label class="checkbox">'
                                    . $q['presenters'] . 
                                '</label>
                            </div>
                        </div>
                        <div class="form-actions">
                            <a class="btn" href="' . basename(__FILE__) . '">Back</a>
                        </div>
                    </div>
                </div>
            </div>';
    }
    
    // Display a form for updating a record within the database.
    function updateForm() {
        $q = query("SELECT * FROM ugrp_events WHERE id = " . $_GET['id']);
        $q = $q->fetch(PDO::FETCH_ASSOC);
        echo '
            <div class="container">
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Update Event</h3>
                    </div>
                    <input type="hidden" id="event_id" name="event_id" value="' . $_GET['id'] . '"/>
                    <div class="form-horizontal">
                        <div class="control-group">' . 
                            '<label class="control-label">Event Type</label>' .
                            '<div class="controls">
                                <select id="event_type">
                                    <option value="schedule"' . ( $q['event_type'] == "schedule" ? 'selected="selected"' : '') . '>
                                        schedule
                                    </option>
                                    <option value="poster"' . ($q['event_type'] == "poster" ? ' selected' : '') . '>
                                        poster
                                    </option>
                                    <option value="paper"' . ($q['event_type'] == "paper" ? ' selected' : '') . '>
                                        paper
                                    </option>
                                    <option value="performance"' . ($q['event_type'] == "performance" ? ' selected' : '') . '>
                                        performance
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Start Time</label>
                            <div class="controls">
                                <input id="start_time" name="start_time" type="time" value="' . $q['start_time'] . '">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">End Time</label>
                            <div class="controls">
                                <input id="end_time" name="end_time" type="time" value="' . $q['end_time'] . '">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Date</label>
                            <div class="controls">
                                <input id="event_date" name="event_date" type="date" value="' . $q['event_date'] . '">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Location</label>
                            <div class="controls">
                                <input id="location" name="location" value="' . $q['location'] . '">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Title</label>
                            <div class="controls">
                                <textarea id="title" name="title">' . $q['title'] . '</textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Description</label>
                            <div class="controls">
                                <textarea id="description" name="description">' . $q['description'] . '</textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Presenters</label>
                            <div class="controls">
                                <textarea id="presenters" name="presenters">' . $q['presenters'] . '</textarea>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button class="btn btn-success" onClick="submitForm(\'update\');">Update</button>
                            <a class="btn" href="' . basename(__FILE__) . '">Back</a>
                        </div>
                    </div>
                </div>
            </div>';
    }
    
    // Display a form for deleting a record from the database.
    function deleteForm() {
        echo '
            <div class="container">
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Delete Event</h3>
                    </div>
                    <div class="form-horizontal">
                        <input type="hidden" id="event_id" name="event_id" value="' . $_GET['id'] . '"/>
                        <p class="alert alert-error">Are you sure you want to delete ?</p>
                        <div class="form-actions">
                            <button id="submit" class="btn btn-danger" onClick="submitForm(\'delete\');">Yes</button>
                            <a class="btn" href="' . basename(__FILE__) . '">No</a>
                        </div>
                    </div>
                </div>
            </div>';
    }
    
    // Display a table containing details about every record in the database.
    function displayTable() {        
        echo '
            <div class="container">
            <div class="span10 offset1">
            <div class="row">
                <h3>UGRP</h3>
                <button class="btn btn-success" onClick="getForm(\'create\');">CREATE</button>
            </div>
            <table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>ID</th>
                        <th>Event_Type</th>
                        <th>Event_Date</th>
						<th>Start_Time</th>
                        <th>Title</th>
                        <th></th>
					</tr>
				</thead>
				<tbody>';                
        foreach(query("SELECT * FROM ugrp_events") as $row) {
            echo    '<tr>'
                        . '<td>' . $row['id']         . '</td>'
                        . '<td>' . $row['event_type'] . '</td>'
                        . '<td>' . $row['event_date'] . '</td>'
                        . '<td>' . $row['start_time'] . '</td>'
                        . '<td>' . $row['title']      . '</td>'
                        . '<td>'
                            . '<button class="btn btn-success" onClick="getForm(\'read\', \''
                                . $row['id'] . '\');">read</button><br>' 
                            . '<button class="btn btn-success" onClick="getForm(\'update\', \''
                                . $row['id'] . '\');">update</button><br>'
                            . '<button class="btn btn-danger" onClick="getForm(\'delete\', \''
                                . $row['id'] . '\')";>delete</button>'
                        . '</td>'
                    . '</tr>';
        }
        echo '</tbody></table></div></div>';
    }
?>
</body>
</html>