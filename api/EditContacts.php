<?php
    // Sends a JSON response
    function sendResponse($obj)
    {
        header('Content-type: application/json');
        echo $obj;
    }

    // Sends error JSON (empty string means success)
    function sendError($errorMessage)
    {
        $obj = '{"error":"' . $errorMessage . '"}';
        sendResponse($obj);
    }

    $inputs = json_decode(file_get_contents('php://input'), true);

    // Validate required inputs
    $required = ["contactID", "userID", "firstName", "lastName", "phone", "email", "vaultNumber"];
    foreach ($required as $key)
    {
        if (!isset($inputs[$key]))
        {
            sendError("Missing " . $key);
            exit();
        }
    }

    $contactID   = intval($inputs["contactID"]);
    $userID      = intval($inputs["userID"]);
    $firstName   = $inputs["firstName"];
    $lastName    = $inputs["lastName"];
    $phone       = $inputs["phone"];
    $email       = $inputs["email"];
    $vaultNumber = intval($inputs["vaultNumber"]);

    // DB connection
    $connection = new mysqli("localhost", "VaultBook", "POOSD6", "COP4331");
    if ($connection->connect_error)
    {
        sendError($connection->connect_error);
        exit();
    }

    // Update only if the contact belongs to the user
    $query = $connection->prepare(
        "UPDATE Contacts
         SET FirstName = ?, LastName = ?, Phone = ?, Email = ?, VaultNumber = ?
         WHERE ID = ? AND UserID = ?;"
    );

    if (!$query)
    {
        sendError("Failed to prepare update statement");
        $connection->close();
        exit();
    }

    $query->bind_param("ssssiii", $firstName, $lastName, $phone, $email, $vaultNumber, $contactID, $userID);

    if ($query->execute())
    {
        if ($query->affected_rows > 0)
        {
            sendError(""); // success
        }
        else
        {
            // Could be "no change" OR wrong ID/userID.
            // If you want to treat "no change" as success, remove this branch and always return "" on execute().
            sendError("No contact updated (not found, not owned by user, or no changes)");
        }
    }
    else
    {
        sendError("Error updating contact in database");
    }

    $query->close();
    $connection->close();
?>
