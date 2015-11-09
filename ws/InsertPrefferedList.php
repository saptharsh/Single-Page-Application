<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';
    include_once '../classes/MongoLogger.php';

    $dbConnection = new PDOExt();
    $utilities = new Utilities();
    $log = new MongoLogger(basename($_SERVER['PHP_SELF']));

    $response = array();

    $log->setPostReq($_POST);

    $user_id = $utilities->replaceZero($_POST['user_id']);
    $item_id = $utilities->replaceZero($_POST['item_id']);
    $serving_id = $utilities->replaceZero($_POST['serving_id']);

    $log_datetime = $utilities->replaceNow();

    $preferredId = -1;

    try
    {
        $insertQuery = "INSERT INTO "
                . " `preffered_list` (user_id, item_id, serving_id, log_datetime) "
                . " VALUES ('$user_id', '$item_id', '$serving_id', '$log_datetime')";

        $log->info("Query:" . $insertQuery);
        $statement = $dbConnection->prepare($insertQuery);

        try
        {
            $dbConnection->beginTransaction();
            if ($statement->execute())
            {
                $preferredId = $dbConnection->lastInsertId();
                $dbConnection->commit();

                $log->info("Inserted Preferred Id successfully with id:" . $preferredId);
                $response = array('status' => $preferredId, 'desc' => 'Success');
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
