<?php
    // Creates body of json object with empty data and error message specifed by errorMessage
    function sendError($errorMessage)
    {
        $obj = '{"id":0,
                 "firstName":"",
                 "lastName":"",
                 "dateCreated":"",
                 "vaultNum":0,
                 "error":"' . $errorMessage . '"}';
        sendResponse($obj);
    }

    // Adds header to json object specified by jsonObj and sends it to client
    function sendResponse($jsonObj)
    {
        header('Content-type: application/json');
		echo $jsonObj;
    }
    
    // Create associative array (like dictionary/hash table) with decoded json from api request
    $inputs = json_decode(file_get_contents('php://input'), true);
	
    // Create MySQL db connection, providing all specified info
    $connection = new mysqli("localhost", "", "", "COP4331"); // Update with admin info

    // Checks for connection errors
    if($connection)
    {
        // Prepared statement for querying in database prevents sql injection
        $query = $connection->prepare("SELECT ID,firstName,lastName FROM Users WHERE Login=? AND Password =?");

        // Puts user login info from request into statement, ss means both first and second variable are strings
        $query->bind_param("ss", $inputs["login"], $inputs["password"]);

        // Send query and recieve data from database in array-like form where every row is one index
        $query->execute();
        $response = $query->get_result();

        // Creates associative array with one row (the user's data) if a result is found, else return false
        if($userInfo = $response->fetch_assoc())
        {
            $obj = '{"id":'.$userInfo["ID"].',
                     "firstName":'.$userInfo["FirstName"].',
                     "lastName":'.$userInfo["LastName"].',
                     "dateCreated":'.$userInfo["DateCreated"].',
                     "vaultNum":'.$userInfo["VaultNumber"].',
                     "error":""}';
            sendResponse($obj);
        }

        // Frees database resources to avoid memory leaks
        $query->close();
        $connection->close();
    }
    else
    {
        sendError($connection->connect_error);
    }
?>