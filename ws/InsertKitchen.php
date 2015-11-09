<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';
    include_once '../classes/MongoLogger.php';

    $dbConnection = new PDOExt();
    $utilities = new Utilities();
    $log = new MongoLogger(basename($_SERVER['PHP_SELF']));

    $response = array();

    $log->setPostReq($_POST);

    $name = $utilities->clean($_POST['name']);
    $area = $utilities->clean($_POST['area']);
    $pincode = $utilities->clean($_POST['pincode']);
    $latitude = $utilities->replaceZero($_POST['latitude']);
    $longitude = $utilities->replaceZero($_POST['longitude']);

    $log_datetime = $utilities->replaceNow();

    $kitchenId = -1;

    try
    {
        $insertQuery = "INSERT INTO "
                . " `kitchen` (name, area, pincode, latitude, longitude, log_datetime) "
                . " VALUES ('$name', '$area', '$pincode', '$latitude', '$longitude', '$log_datetime')";

        $log->info("Query:" . $insertQuery);
        $statement = $dbConnection->prepare($insertQuery);

        try
        {
            $dbConnection->beginTransaction();
            if ($statement->execute())
            {
                $kitchenId = $dbConnection->lastInsertId();
                $dbConnection->commit();

                $log->info("Inserted kitchen successfully with id:" . $kitchenId);
                $response = array('status' => $kitchenId, 'desc' => 'Success');
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
