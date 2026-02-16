<?php
    // Creates body of json object with empty data and error message specifed by errorMessage
    function sendError($errorMessage)
    {
        $obj = '{"id":0,
                 "firstName":"",
                 "lastName":"",
                 "dateCreated":"",
                 "error":"' . $errorMessage . '"}';
        sendResponse($obj);
    }

    // Adds header to json object specified by jsonObj and sends it to client
    function sendResponse($jsonObj)
    {
        header('Content-type: application/json');
		echo $jsonObj;
    }
    
    // Get username and password
    $inputs = json_decode(file_get_contents('php://input'), true);
    
    // Create MySQL database connection
    $connection = new mysqli("localhost", "", "", "");
    if(!$connection->connect_error)
    {
        // Search for user in the database
        $query = $connection->prepare("SELECT ID, FirstName, LastName FROM Users WHERE Login=? AND Password =?");
        $query->bind_param("ss", $inputs["login"], $inputs["password"]);
        $query->execute();

        // If a user is found, get and send its data
        $response = $query->get_result();
        if($userInfo = $response->fetch_assoc())
        {
            $obj = '{"id":'.$userInfo["ID"].',
                     "firstName":"'.$userInfo["FirstName"].'",
                     "lastName":"'.$userInfo["LastName"].'",
                     "dateCreated":"'.$userInfo["DateCreated"].'",
                     "error":""}';
            sendResponse($obj);
        }
        else
        {
            sendError("Invalid username or password");
        }

        $query->close();
        $connection->close();
    }
    else
    {
        sendError($connection->connect_error);
    }
?>