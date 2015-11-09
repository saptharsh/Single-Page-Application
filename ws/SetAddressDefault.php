<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';
    include_once '../classes/MongoLogger.php';

    $dbConnection = new PDOExt();
    $utilities = new Utilities();
    $log = new MongoLogger(basename($_SERVER['PHP_SELF']));

    $response = array();

    $log->setPostReq($_POST);

    $address_id = $utilities->clean($_POST['address_id']);
    $user_id = $utilities->clean($_POST['user_id']);

    $log_datetime = $utilities->replaceNow();

    try
    {

            $query = "UPDATE `address` SET"
                    . " is_default = '0' "
                    . " WHERE user_id = '$user_id';"
                    . ""
                    . ""
                    . "UPDATE `address` SET"
                    . " is_default = '1' "
                    . " WHERE address_id = '$address_id';";

        $log->info("Query:" . $query);
        $statement = $dbConnection->prepare($query);

        try
        {
            $dbConnection->beginTransaction();
            if ($statement->execute())
            {
                $dbConnection->commit();

                $log->info("Address set as default successfully with id:" . $address_id);
                $response = array('status' => $address_id, 'desc' => 'Success');
            }
            else
            {
                $status = -99;
                $dbError = $statement->errorInfo();
                $log->error($dbError[2]);
                $response = array('status' => $status, 'desc' => 'DB error occured' . $dbError[2]);
            }
        }
        catch (PDOExecption $e)
        {
            $status = -7;
            $error = "Exception: " . $e->getMessage();
            $log->error($error);
            $response = array('status' => $status, 'desc' => 'PDO exception occured' . $error);
        }

        $statement->closeCursor();
    }
    catch (PDOExecption $e)
    {
        $status = -8;
        $error = "Exception: " . $e->getMessage();
        $log->error($error);
        $response = array('status' => $status, 'desc' => 'PDO exception occured' . $error);
    }

    $log->endLogger();

    header("Content-type: application/json");
    echo json_encode($response);
?>
