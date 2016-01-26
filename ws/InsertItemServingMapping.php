<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';
    
    $dbConnection = new PDOExt();
    $utilities = new Utilities();
    
    $response = array();

    $item_id = $utilities->replaceZero($_POST['item_id']);
    $serving_id = $utilities->replaceZero($_POST['serving_id']);
    $available_for = $utilities->replaceZero($_POST['available_for']);
    $order_count = $utilities->replaceZero($_POST['order_count']);
    $date = $utilities->replaceZero($_POST['date']);

    $log_datetime = $utilities->replaceNow();

    $itemServingMappingId = -1;

    try
    {
        $insertQuery = "INSERT INTO "
                . " `item_serving_mapping` (item_id, serving_id, available_for, order_count, date, log_datetime) "
                . " VALUES ('$item_id', '$serving_id', '$available_for', '$order_count', '$date', '$log_datetime')";

        $statement = $dbConnection->prepare($insertQuery);

        try
        {
            $dbConnection->beginTransaction();
            if ($statement->execute())
            {
                $itemServingMappingId = $dbConnection->lastInsertId();
                $dbConnection->commit();

                $response = array('status' => $itemServingMappingId, 'desc' => 'Success');
            }
            else
            {
                $status = -99;
                $dbError = $statement->errorInfo();
    
                $response = array('status' => $status, 'desc' => 'DB error occured' . $dbError[2]);
            }
        }
        catch (PDOExecption $e)
        {
            $status = -7;
            $error = "Exception: " . $e->getMessage();
    
            $response = array('status' => $status, 'desc' => 'PDO exception occured' . $error);
        }

        $statement->closeCursor();
    }
    catch (PDOExecption $e)
    {
        $status = -8;
        $error = "Exception: " . $e->getMessage();
    
        $response = array('status' => $status, 'desc' => 'PDO exception occured' . $error);
    }

    header("Content-type: application/json");
    echo json_encode($response);
?>
