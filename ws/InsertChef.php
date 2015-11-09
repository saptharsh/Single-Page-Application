<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';
    include_once '../classes/MongoLogger.php';

    $dbConnection = new PDOExt();
    $utilities = new Utilities();
    $log = new MongoLogger(basename($_SERVER['PHP_SELF']));

    $response = array();

    $log->setPostReq($_POST);

    $f_name = $utilities->clean($_POST['f_name']);
    $l_name = $utilities->clean($_POST['l_name']);
    $country_code = $utilities->replaceDefaultCountryCode($_POST['country_code']);
    $phone_number = $utilities->clean($_POST['phone_number']);
    $image_url = $utilities->clean($_POST['image_url']);
    $rating = $utilities->replaceZero($_POST['rating']);

    $log_datetime = $utilities->replaceNow();

    $chefId = -1;

    try
    {
        $insertQuery = "INSERT INTO "
                . " `chef` (f_name, l_name, country_code, phone_number, image_url, rating, log_datetime) "
                . " VALUES ('$f_name', '$l_name', '$country_code', '$phone_number', '$image_url', '$rating', '$log_datetime')";

        $log->info("Query:" . $insertQuery);
        $statement = $dbConnection->prepare($insertQuery);

        try
        {
            $dbConnection->beginTransaction();
            if ($statement->execute())
            {
                $chefId = $dbConnection->lastInsertId();
                $dbConnection->commit();

                $log->info("Inserted chef successfully with id:" . $chefId);
                $response = array('status' => $chefId, 'desc' => 'Success');
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
