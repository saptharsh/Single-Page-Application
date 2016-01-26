<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';
    
    $dbConnection = new PDOExt();
    $utilities = new Utilities();
    
    $response = array();

    $street_address = $utilities->clean($_POST['street_address']);
    $landmark = $utilities->clean($_POST['landmark']);
    $city = $utilities->clean($_POST['city']);
    $state = $utilities->clean($_POST['state']);
    $country = $utilities->clean($_POST['country']);
    $pincode = $utilities->clean($_POST['pincode']);
    $phone_number = $utilities->clean($_POST['phone_number']);
    $country_code = $utilities->clean($_POST['country_code']);
    $is_default = $utilities->replaceZero($_POST['is_default']);
    $user_id = $utilities->replaceZero($_POST['user_id']);
    
    $log_datetime = $utilities->replaceNow();

    $addressId = -1;

    try
    {
        $insertQuery = "INSERT INTO "
                . " `address` (street_address, landmark, city, state, country, pincode, phone_number, country_code, is_default, user_id, log_datetime) "
                . " VALUES ('$street_address', '$landmark', '$city', '$state', '$country', '$pincode', '$phone_number', '$country_code', '$is_default', '$user_id', '$log_datetime')";

        $statement = $dbConnection->prepare($insertQuery);

        try
        {
            $dbConnection->beginTransaction();
            if ($statement->execute())
            {
                $addressId = $dbConnection->lastInsertId();
                $dbConnection->commit();
    
                $response = array('status' => $addressId, 'desc' => 'Success');
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
