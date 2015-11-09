<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';
    include_once '../classes/MongoLogger.php';

    $dbConnection = new PDOExt();
    $utilities = new Utilities();
    $log = new MongoLogger(basename($_SERVER['PHP_SELF']));

    $response = array();

    $log->setPostReq($_POST);

    $basket_code = uniqid("BSKT_");
    /*
     * Json array with id, qunatity in this format.
     * [
     *  {'item':1,'name': 'xyz','quantity':2,'price':200},
     *  {'item':2,'name': 'abc','quantity':1,'price':150},
     *  {'item':3,'name': 'qwert','quantity':1,'price':20},
     *  {'item':4,'name': 'poiuyt','quantity':1,'price':30}
     * ]
     */

    $item_quantity_price_json = $utilities->clean($_POST['item_quantity_price_json']);
    $user_id = $utilities->replaceOne($_POST['user_id']);
    $time_slot_id = $utilities->replaceOne($_POST['time_slot_id']);
    $status = $utilities->replaceOne($_POST['status']);
    $date = $utilities->replaceToday($_POST['date']);
    $address_id = $utilities->replaceZero($_POST['address_id']);
    $order_type_id = $utilities->replaceZero($_POST['order_type_id']);
    $log_datetime = $utilities->replaceNow();

    $order_id = -1;

    try
    {
        $insertQuery = "INSERT INTO "
                . " `order` (basket_code, user_id, item_quantity_price_json, time_slot_id, status, date, address_id, log_datetime) "
                . " VALUES ('$basket_code', '$user_id', '$item_quantity_price_json', '$time_slot_id', '$status', '$date', '$address_id', '$log_datetime')";

        $log->info("Query:" . $insertQuery);
        $statement = $dbConnection->prepare($insertQuery);

        try
        {
            $dbConnection->beginTransaction();
            if ($statement->execute())
            {
                $order_id = $dbConnection->lastInsertId();
                $dbConnection->commit();

                $log->info("Inserted order successfully with id:" . $order_id);
                $response = array('status' => $order_id, 'basket_code' => $basket_code, 'desc' => 'Success');
            }
            else
            {
                $status = -99;
                $dbError = $statement->errorInfo();
                $log->error($dbError[2]);
                $response = array('status' => $status, 'basket_code' => '', 'desc' => 'DB error occured' . $dbError[2]);
            }
        }
        catch (PDOExecption $e)
        {
            $status = -7;
            $error = "Exception: " . $e->getMessage();
            $log->error($error);
            $response = array('status' => $status, 'basket_code' => '', 'desc' => 'PDO exception occured' . $error);
        }

        $statement->closeCursor();
    }
    catch (PDOExecption $e)
    {
        $status = -8;
        $error = "Exception: " . $e->getMessage();
        $log->error($error);
        $response = array('status' => $status, 'basket_code' => '', 'desc' => 'PDO exception occured' . $error);
    }

    $log->endLogger();

    header("Content-type: application/json");
    echo json_encode($response);
?>
