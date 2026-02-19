<?php
    // Creates body of json object with empty data and error message specifed by errorMessage
    function sendError($errorMessage)
    {
        $obj = '{"error":"' . $errorMessage . '"}';
        sendResponse($obj);
    }
    
    function sendResponse($obj)
    {
        header('Content-type: application/json');
        echo $obj;
    }
    
    // Get user's username, contact's first name, last name, phone, email
    $inputs = json_decode(file_get_contents('php://input'), true);
    
    // Create MySQL database connection
    $connection = new mysqli("localhost", "", "", "");
    if($connection->connect_error)
    {
        sendError($connection->connect_error);
    }
    else
    {
        // Insert user into database
        $query = $connection->prepare("INSERT INTO Contacts (FirstName,Lastname,Phone,Email,UserID)
                                        VALUES  (?,?,?,?,?);");
        $query->bind_param("ssssi", $inputs["firstName"], $inputs["lastName"], 
                             $inputs["phone"], $inputs["email"], $inputs["userID"]);        

        if($query->execute())
        {
            sendResponse('{"error":"", 
                                    "response":"Added Contact"}');
        }
        else
        {
            sendError("Error adding contact info to database");
        }

        $query->close();
        $connection->close();
    }
?>
