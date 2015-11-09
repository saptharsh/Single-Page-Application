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

        $log->info("Query:" . $query);
        $statement = $dbConnection->prepare($query);

        try
        {
            if ($statement->execute($bindParams))
            {
                $datauser = $statement->fetchAll(PDO::FETCH_ASSOC);
                $statement->closeCursor();

                $log->info("User already exists...");
                $log->arrayMultiLogger($datauser, 'Result for user');

                $smsStatus = $utilities->sendSMSMoryaas($country_code . $phone_number, $sms_body);
                $log->info("Sending SMS to user is: " . $smsStatus);

                $userId = $datauser[0]['user_id'];

                $response = array('status' => $datauser[0]['user_id'], 'desc' => 'success');
            }
            else
            {
                $errorCode = -99;
                $dbError = $statement->errorInfo();
                $statement->closeCursor();
                $log->error($dbError[2]);
                $response = array('status' => $errorCode, 'desc' => 'success');
            }
        }
        catch (PDOExecption $e)
        {
            $errorCode = -7;
            $statement->closeCursor();
            $error = "Exception: " . $e->getMessage();
            $log->error($error);
            $response = array('status' => $errorCode, 'desc' => 'PDO exception occured' . $error);
        }
    }
    catch (PDOExecption $e)
    {
        $errorCode = -8;
        $error = "Exception: " . $e->getMessage();
        $log->error($error);
        $response = array('status' => $errorCode, 'desc' => 'PDO exception occured' . $error);
    }


    if (count($datauser) == 0)
    {
        try
        {
            $insertQuery = "INSERT INTO "
                    . " `user` (f_name, l_name, country_code, phone_number, email, image_url, date_of_birth, log_datetime) "
                    . " VALUES ('$f_name', '$l_name', '$country_code', '$phone_number', '$email', '$image_url', '$date_of_birth', '$log_datetime')";

            $log->info("Query:" . $insertQuery);
            $statement = $dbConnection->prepare($insertQuery);

            try
            {
                $dbConnection->beginTransaction();
                if ($statement->execute())
                {
                    $userId = $dbConnection->lastInsertId();
                    $dbConnection->commit();
                    
                    $smsStatus = $utilities->sendSMSMoryaas($country_code . $phone_number, $sms_body);
                    $log->info("Sending SMS to user is: " . $smsStatus);

                    $log->info("Inserted User successfully with id:" . $userId);
                    $response = array('status' => $userId, 'desc' => 'Success');
                }
                else
                {
                    $status = -99;
                    $dbError = $statement->errorInfo();
                    $log->error($dbError[2]);
                    $response = array('status' => $status, 'desc' => 'DB error occured: ' . $dbError[2]);
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
    }

    /*
     * TODO Send sms to given number with $verification_code;
     */
    $response = array('status' => $userId, 'desc' => 'Success');

    $log->endLogger();

    header("Content-type: application/json");
    echo json_encode($response);
?>
