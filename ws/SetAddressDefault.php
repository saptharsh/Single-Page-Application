<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';

    $dbConnection = new PDOExt();
    $utilities = new Utilities();

    $response = array();

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


        $statement = $dbConnection->prepare($query);

        try
        {
            $dbConnection->beginTransaction();
            if ($statement->execute())
            {
                $dbConnection->commit();

                $response = array('status' => $address_id, 'desc' => 'Success');
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
