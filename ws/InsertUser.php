<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';
    
    $dbConnection = new PDOExt();
    $utilities = new Utilities();
    
    $response = array();

    $f_name = $utilities->clean($_POST['f_name']);
    $l_name = $utilities->clean($_POST['l_name']);
    $country_code = $utilities->clean($_POST['country_code']);
    $phone_number = $utilities->clean($_POST['phone_number']);
    $email = $utilities->clean($_POST['email']);
    $image_url = $utilities->clean($_POST['image_url']);
    $verification_code = $utilities->clean($_POST['verification_code']);
    $date_of_birth = $utilities->replaceDefaultDate($_POST['date_of_birth']);

    $log_datetime = $utilities->replaceNow();

    $userId = -1;

    $datauser = array();

    $sms_body = "FoodizHome: Please use $verification_code for validating your registration.";

    try
    {
        $query = "SELECT user_id
                FROM `user`
                WHERE `user`.phone_number = '$phone_number';";

        $statement = $dbConnection->prepare($query);

        try
        {
            if ($statement->execute($bindParams))
            {
                $datauser = $statement->fetchAll(PDO::FETCH_ASSOC);
                $statement->closeCursor();

                $userId = $datauser[0]['user_id'];

                $response = array('status' => $datauser[0]['user_id'], 'desc' => 'success');
            }
            else
            {
                $errorCode = -99;
                $dbError = $statement->errorInfo();
                $statement->closeCursor();

                $response = array('status' => $errorCode, 'desc' => 'success');
            }
        }
        catch (PDOExecption $e)
        {
            $errorCode = -7;
            $statement->closeCursor();
            $error = "Exception: " . $e->getMessage();

            $response = array('status' => $errorCode, 'desc' => 'PDO exception occured' . $error);
        }
    }
    catch (PDOExecption $e)
    {
        $errorCode = -8;
        $error = "Exception: " . $e->getMessage();

        $response = array('status' => $errorCode, 'desc' => 'PDO exception occured' . $error);
    }


    if (count($datauser) == 0)
    {
        try
        {
            $insertQuery = "INSERT INTO "
                    . " `user` (f_name, l_name, country_code, phone_number, email, image_url, date_of_birth, log_datetime) "
                    . " VALUES ('$f_name', '$l_name', '$country_code', '$phone_number', '$email', '$image_url', '$date_of_birth', '$log_datetime')";

            $statement = $dbConnection->prepare($insertQuery);

            try
            {
                $dbConnection->beginTransaction();
                if ($statement->execute())
                {
                    $userId = $dbConnection->lastInsertId();
                    $dbConnection->commit();
                    
                    $response = array('status' => $userId, 'desc' => 'Success');
                }
                else
                {
                    $status = -99;
                    $dbError = $statement->errorInfo();
            
                    $response = array('status' => $status, 'desc' => 'DB error occured: ' . $dbError[2]);
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
    }

    /*
     * TODO Send sms to given number with $verification_code;
     */
    $response = array('status' => $userId, 'desc' => 'Success');

    header("Content-type: application/json");
    echo json_encode($response);
?>
