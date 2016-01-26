<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';
    
    $dbConnection = new PDOExt();
    $utilities = new Utilities();
    
    $response = array();

    $user_id = $utilities->replaceZero($_POST['user_id']);
    $item_id = $utilities->replaceZero($_POST['item_id']);
    $serving_id = $utilities->replaceZero($_POST['serving_id']);

    $preferredId = -1;

    try
    {
        $insertQuery = "INSERT INTO "
                . " `preffered_list` (user_id, item_id, serving_id, log_datetime) "
                . " VALUES ('$user_id', '$item_id', '$serving_id', '$log_datetime')";

        $statement = $dbConnection->prepare($insertQuery);

        try
        {
            $dbConnection->beginTransaction();
            if ($statement->execute())
            {
                $preferredId = $dbConnection->lastInsertId();
                $dbConnection->commit();

                $response = array('status' => $preferredId, 'desc' => 'Success');
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
