<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';
    include_once '../classes/MongoLogger.php';

    $dbConnection = new PDOExt();
    $utilities = new Utilities();
    $log = new MongoLogger(basename($_SERVER['PHP_SELF']));

    $response = array();

    $log->setPostReq($_POST);

    $isUpdate = $utilities->replaceZero($_POST['is_update_address']);
    $address_id = $utilities->clean($_POST['address_id']);

    $street_address = $utilities->clean($_POST['street_address']);
    $landmark = $utilities->clean($_POST['landmark']);
    $city = $utilities->clean($_POST['city']);
    $state = $utilities->clean($_POST['state']);
    $pincode = $utilities->clean($_POST['pincode']);
    $phone_number = $utilities->clean($_POST['phone_number']);
    $is_default = $utilities->replaceZero($_POST['is_default']);
    $user_id = $utilities->clean($_POST['user_id']);

    $log_datetime = $utilities->replaceNow();

    $addressId = -1;

    try
    {
        if ($isUpdate == 0)
        {
            $query = "INSERT INTO "
                    . " `address` (street_address, landmark, city, state, country, pincode, phone_number, country_code, is_default, user_id, log_datetime) "
                    . " VALUES ('$street_address', '$landmark', '$city','$state', 'country', '$pincode', '$phone_number', '+91', '$is_default', '$user_id' ,'$log_datetime')";
        }
        else
        {
            $query = "UPDATE `address` SET"
                    . " street_address = '$street_address', "
                    . " landmark = '$landmark', "
                    . " city = '$city', "
                    . " state = '$state', "
                    . " country = '$country', "
                    . " pincode = '$pincode', "
                    . " phone_number = '$phone_number', "
                    . " country_code = '+91', "
                    . " is_default = '$is_default', "
                    . " log_datetime = '$log_datetime'  "
                    . " WHERE address_id = '$address_id';";
        }

        $log->info("Query:" . $query);
        $statement = $dbConnection->prepare($query);

        try
        {
            $dbConnection->beginTransaction();
            if ($statement->execute())
            {
                $addressId = ($isUpdate == 0) ? $dbConnection->lastInsertId() : $address_id;
                $dbConnection->commit();

                $log->info("Inserted address successfully with id:" . $addressId);
                $response = array('status' => $addressId, 'desc' => 'Success');
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
