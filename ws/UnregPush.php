<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';
    include_once '../classes/Logger.php';

    $dbConnection = new PDOExt();
    $utilities = new Utilities();
    $log = new Logger(basename($_SERVER['PHP_SELF']));

    $response = array();

    $log->arrayLogger($_POST, "Data Requested");

    $device_imei = $utilities->clean($_POST['deviceIMEI']);

    $dateTime = $utilities->replaceNow();

    $status = 0;

    try
    {

        $delQuery = "DELETE FROM `push_reg` WHERE device_imei = '$device_imei'";

        $log->info("Query:" . $delQuery);
        $statement = $dbConnection->prepare($delQuery);

        $statement->bindParam(":device_imei", $device_imei, PDO::PARAM_STR);

        try
        {
            $dbConnection->beginTransaction();
            if ($statement->execute())
            {
                $dbConnection->commit();

                $log->info("Deleted tag successfully with id:" . $likeId);
                $response = array('status' => $status, 'desc' => 'Success');
            }
            else
            {
                $status = -99;
                $dbError = $statement->errorInfo();
                $log->error($dbError[2]);
                $response = array('status' => $status, 'desc' => 'DB error occured: ' . $dbError[2]);
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
