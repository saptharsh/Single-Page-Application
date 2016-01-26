<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';
    
    $dbConnection = new PDOExt();
    $utilities = new Utilities();
    
    $response = array();

    $dateTime = $utilities->replaceNow();

    try
    {
        $query = "SELECT chef.chef_id,
                        CONCAT(chef.f_name, ' ', chef.l_name) AS chef_name,
                        CONCAT(chef.country_code,chef.phone_number) AS chef_phone_number,
                        chef.image_url AS chef_image_url,
                        chef.rating,
                        chef.log_datetime
                FROM chef
                ORDER BY chef.f_name ASC;";

        $statement = $dbConnection->prepare($query);

        try
        {
            if ($statement->execute())
            {
                $data = $statement->fetchAll(PDO::FETCH_ASSOC);
                
                $statement->closeCursor();

                $response = array('status' => 0, 'data' => $data, 'desc' => 'success');
            }
            else
            {
                $errorCode = -99;
                $dbError = $statement->errorInfo();
                $statement->closeCursor();
                
                $response = array('status' => $errorCode, 'data' => array(), 'desc' => 'DB error occured' . $dbError[2]);
            }
        }
        catch (PDOExecption $e)
        {
            $errorCode = -7;
            $statement->closeCursor();
            $error = "Exception: " . $e->getMessage();
            
            $response = array('status' => $errorCode, 'data' => array(), 'desc' => 'PDO exception occured' . $error);
        }
    }
    catch (PDOExecption $e)
    {
        $errorCode = -8;
        $error = "Exception: " . $e->getMessage();
        
        $response = array('status' => $errorCode, 'data' => array(), 'desc' => 'PDO exception occured' . $error);
    }

    

    header("Content-type: application/json");
    echo json_encode($response);
?>