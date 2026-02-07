<?php
    // Creates body of json object with empty data and error message specifed by errorMessage
    function sendError($errorMessage) {
        $obj = '{"results":[], "error":"' . $errorMessage . '"}';
        sendResponse($obj);
    }

    // Adds header to json object specified by jsonObj and sends it to client
    function sendResponse($jsonObj) {
        header('Content-type: application/json');
        echo $jsonObj;
    }

    // Get the query from the user
    $inputs = json_decode(file_get_contents('php://input'), true);

    // Save them in variables
    $match = $inputs["search"];
    $userId = $inputs["userId"]; 

    $conn = new mysqli("localhost", "", "", "COP4331");
    if($conn->connect_error){
        sendError($conn->connect_error);
    }else{
        // Search via partial matching
        $search = "%".$march."%";
        $stmt = $conn->prepare("SELECT * FROM Contact WHERE (FirstName LIKE ? OR LastName LIKE ?) AND UserID = ?");
        $stmt->bind_param("ssi", $search, $search, $userId);
        $stmt->execute();

        $result = $stmt->get_result();
        $searchCount = 0;
        $searchResults = "";

        // Feth any results with an associative array
        while($row = $result->fetch_assoc()) {
            if($searchCount > 0){
                $searchResults .= "";
            }
            $searchCount++;
            // Append all of the results in a variable
            $searchResults .= $row["FirstName"]. ", ". $row["LastName"] .", ". $row["Phone"] .", ".
                                $row["Email"] .", ". $row["ID"];
        }  

        // If no results, send an error message
        if($searchCount ==0){
            sendError("No Records Found");
        }
        else{
            sendResponse('{"results":['. $searchResults . '], "error":""}');
        }

        $stmt->close();
        $conn->close();
        
    }
?>