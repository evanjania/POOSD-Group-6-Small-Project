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
    
    // Get new user's first name, last name, login, and password
    $inputs = json_decode(file_get_contents('php://input'), true);
    if($inputs == null)
    {
        sendError("No data");
        exit();
    }
	
    // Create MySQL database connection
    $connection = new mysqli("localhost", "", "", "");
    if(!$connection->connect_error)
    {
        // Search for user in the database
        $query = $connection->prepare("SELECT * FROM Users WHERE Login=?");
        $query->bind_param("s", $inputs["login"]);        
        $query->execute();

        $response = $query->get_result();

        // If user exists in database send an error
        if($userInfo = $response->fetch_assoc())
        {
            sendError("Username already exists in database");
        }
        else
        {
            // Insert user into database
            $query = $connection->prepare("INSERT INTO Users (FirstName, LastName, Login, Password)
                                           VALUES (?,?,?,?);");
            $query->bind_param("ssss", $inputs["firstName"], $inputs["lastName"], $inputs["login"], $inputs["password"]);        
            
            if($query->execute())
            {
                $obj = '{"id":0,
                 "firstName":"'.$inputs["firstName"].'",
                 "lastName":"'.$inputs["lastName"].'",
                 "dateCreated":"",
                 "error":""}';
                 sendResponse($obj);
            }
            else
            {
                sendError($query->error);
            }
        }

        $query->close();
        $connection->close();
    }
    else
    {
        sendError($connection->connect_error);
    }
?>