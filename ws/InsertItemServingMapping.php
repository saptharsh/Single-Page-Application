<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';
    //include_once '../classes/MongoLogger.php';

    $dbConnection = new PDOExt();
    $utilities = new Utilities();
    //$log = new MongoLogger(basename($_SERVER['PHP_SELF']));$log

    $response = array();

    //$log->setPostReq($_POST);

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

        //$log->info("Query:" . $insertQuery);
        $statement = $dbConnection->prepare($insertQuery);

        try
        {
            $dbConnection->beginTransaction();
            if ($statement->execute())
            {
                $itemServingMappingId = $dbConnection->lastInsertId();
                $dbConnection->commit();

                //$log->info("Inserted Item Serving Mapping successfully with id:" . $itemServingMappingId);
                $response = array('status' => $itemServingMappingId, 'desc' => 'Success');
            }
            else
            {
                $status = -99;
                $dbError = $statement->errorInfo();
                //$log->error($dbError[2]);
                $response = array('status' => $status, 'desc' => 'DB error occured' . $dbError[2]);
            }
        }
        catch (PDOExecption $e)
        {
            $status = -7;
            $error = "Exception: " . $e->getMessage();
            //$log->error($error);
            $response = array('status' => $status, 'desc' => 'PDO exception occured' . $error);
        }

        $statement->closeCursor();
    }
    catch (PDOExecption $e)
    {
        $status = -8;
        $error = "Exception: " . $e->getMessage();
        //$log->error($error);
        $response = array('status' => $status, 'desc' => 'PDO exception occured' . $error);
    }

    //$log->endLogger();

    header("Content-type: application/json");
    echo json_encode($response);
?>
