<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';
    
    $dbConnection = new PDOExt();
    $utilities = new Utilities();
    
    $response = array();

    $userId = $utilities->clean($_POST['userId']);
    $push_reg_token = $utilities->clean($_POST['pushRegToken']);
    $device_imei = $utilities->clean($_POST['deviceIMEI']);
    $os_id = $utilities->clean($_POST['osId']);       //1 - Android, 2 - iOS
    $os_name = ($os_id == 1) ? 'Android' : 'iOS';

    $dateTime = $utilities->replaceNow();

    $pushRegId = -1;

    try
    {
        $queryRegPush = "SELECT COUNT(*) AS isPushReg FROM `push_reg` WHERE device_imei = '$device_imei' AND push_reg_token = '$push_reg_token';";
        
        $statement = $dbConnection->prepare($queryRegPush);
        $statement->execute();
        $dataRegPushArray = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();

        if ($dataRegPushArray[0]['isPushReg'] == 0)
        {

            $insertQuery = "INSERT INTO "
                    . " `push_reg` (user_id, push_reg_token, device_imei, os_id, os_name, datetime) "
                    . " VALUES (:user_id, :push_reg_token, :device_imei, :os_id, :os_name, :datetime);";

            $statement = $dbConnection->prepare($insertQuery);

            $statement->bindParam(":user_id", $userId, PDO::PARAM_INT);
            $statement->bindParam(":push_reg_token", $push_reg_token, PDO::PARAM_STR);
            $statement->bindParam(":device_imei", $device_imei, PDO::PARAM_STR);
            $statement->bindParam(":os_id", $os_id, PDO::PARAM_INT);
            $statement->bindParam(":os_name", $os_name, PDO::PARAM_STR);
            $statement->bindParam(":datetime", $dateTime, PDO::PARAM_STR);

            try
            {
                $dbConnection->beginTransaction();
                if ($statement->execute())
                {
                    $pushRegId = $dbConnection->lastInsertId();
                    $dbConnection->commit();

                    $response = array('status' => $pushRegId, 'desc' => 'Success');
                }
                else
                {
                    $pushRegId = -99;
                    $dbError = $statement->errorInfo();
                    
                    $response = array('status' => $pushRegId, 'desc' => 'DB error occured: ' . $dbError[2]);
                }
            }
            catch (PDOExecption $e)
            {
                $pushRegId = -7;
                $error = "Exception: " . $e->getMessage();
                
                $response = array('status' => $pushRegId, 'desc' => 'PDO exception occured' . $error);
            }

            $statement->closeCursor();
        }
        else
        {
            
            $response = array('status' => 0, 'desc' => 'Push already exists with this IMEI and pus token');
        }
    }
    catch (PDOExecption $e)
    {
        $pushRegId = -8;
        $error = "Exception: " . $e->getMessage();
        
        $response = array('status' => $pushRegId, 'desc' => 'PDO exception occured' . $error);
    }

    header("Content-type: application/json");
    echo json_encode($response);
?>
