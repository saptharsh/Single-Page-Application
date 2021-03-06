<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';
    
    $dbConnection = new PDOExt();
    $utilities = new Utilities();
    
    $response = array();

    $user_id = $utilities->replaceZero($_POST['user_id']);
    $item_d = $utilities->replaceZero($_POST['item_d']);
    $rating = $utilities->replaceZero($_POST['rating']);

    $log_datetime = $utilities->replaceNow();

    $user_item_rating = -1;

    try
    {
        $insertQuery = "INSERT INTO "
                . " `user_item_rating` (user_id, item_d, rating, log_datetime) "
                . " VALUES ('$user_id', '$item_d', '$rating', '$log_datetime')";

        $statement = $dbConnection->prepare($insertQuery);

        try
        {
            $dbConnection->beginTransaction();
            if ($statement->execute())
            {
                $user_item_rating = $dbConnection->lastInsertId();
                $dbConnection->commit();

                $response = array('status' => $user_item_rating, 'desc' => 'Success');
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
