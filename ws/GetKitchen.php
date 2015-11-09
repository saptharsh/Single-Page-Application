<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';
    include_once '../classes/MongoLogger.php';

    $dbConnection = new PDOExt();
    $utilities = new Utilities();
    $log = new MongoLogger(basename($_SERVER['PHP_SELF']));

    $response = array();

    $log->setPostReq($_POST);

    $dateTime = $utilities->replaceNow();

    try
    {
        $query = "SELECT kitchen.kitchen_id,
                        kitchen.`name`,
                        kitchen.area,
                        kitchen.pincode,
                        kitchen.latitude,
                        kitchen.longitude,
                        kitchen.log_datetime
                FROM kitchen
                ORDER BY kitchen.`name` ASC;";

        $log->info("Query:" . $query);
        $statement = $dbConnection->prepare($query);

        try
        {
            if ($statement->execute($bindParams))
            {
                $data = $statement->fetchAll(PDO::FETCH_ASSOC);
                $statement->closeCursor();

                $log->arrayMultiLogger($data, 'Result for deals');

                $response = array('status' => 0, 'data' => $data, 'desc' => 'success');
            }
            else
            {
                $errorCode = -99;
                $dbError = $statement->errorInfo();
                $statement->closeCursor();
                $log->error($dbError[2]);
                $response = array('status' => $errorCode, 'data' => array(), 'desc' => 'DB error occured' . $dbError[2]);
            }
        }
        catch (PDOExecption $e)
        {
            $errorCode = -7;
            $statement->closeCursor();
            $error = "Exception: " . $e->getMessage();
            $log->error($error);
            $response = array('status' => $errorCode, 'data' => array(), 'desc' => 'PDO exception occured' . $error);
        }
    }
    catch (PDOExecption $e)
    {
        $errorCode = -8;
        $error = "Exception: " . $e->getMessage();
        $log->error($error);
        $response = array('status' => $errorCode, 'data' => array(), 'desc' => 'PDO exception occured' . $error);
    }

    $log->endLogger();

    header("Content-type: application/json");
    echo json_encode($response);
?>