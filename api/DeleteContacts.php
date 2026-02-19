<?php
    // Creates body of json object with empty data and error message specified by errorMessage
    function sendResponse($obj)
    {
        header('Content-type: application/json');
        echo $obj;
    }

    function sendError($errorMessage)
    {
        $obj = '{"error":"' . $errorMessage . '"}';
        sendResponse($obj);
    }

    // Read JSON input
    $inputs = json_decode(file_get_contents('php://input'), true);

    // Basic input validation
    if (!isset($inputs["contactID"]) || !isset($inputs["userID"]))
    {
        sendError("Missing contactID or userID");
        exit();
    }

    $contactID = intval($inputs["contactID"]);
    $userID    = intval($inputs["userID"]);

    // Create MySQL database connection
    $connection = new mysqli("localhost", "", "", "");
    if ($connection->connect_error)
    {
        sendError($connection->connect_error);
        exit();
    }

    // Delete only if the contact belongs to the user
    $query = $connection->prepare("DELETE FROM Contacts WHERE ID = ? AND UserID = ?;");
    if (!$query)
    {
        sendError("Failed to prepare delete statement");
        $connection->close();
        exit();
    }

    $query->bind_param("ii", $contactID, $userID);

    if ($query->execute())
    {
        // If no rows affected, either contact doesn't exist or doesn't belong to that user
        if ($query->affected_rows > 0)
        {
            sendError("");
        }
        else
        {
            sendError("No contact deleted (not found or not owned by user)");
        }
    }
    else
    {
        sendError("Error deleting contact from database");
    }

    $query->close();
    $connection->close();
?>
