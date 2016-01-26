<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';
    
    $dbConnection = new PDOExt();
    $utilities = new Utilities();
    
    $response = array();

    $user_id = $utilities->replaceZero($_POST['user_id']);
    $dateTime = $utilities->replaceNow();

    try
    {
        $query = "SELECT address.address_id,
                    CONCAT(address.street_address, '; ', address.city, '; ',  address.state, '; ', address.country, '; ') AS address,
                    address.landmark,
                    address.pincode,
                    CONCAT(address.country_code, address.phone_number) AS address_phone_number,
                    address.is_default,
                    `user`.user_id,
                    CONCAT(`user`.f_name, `user`.l_name) AS user_name,
                    `user`.image_url AS user_image
            FROM address INNER JOIN `user` ON address.user_id = `user`.user_id
            WHERE address.user_id  = '$user_id'";

        $statement = $dbConnection->prepare($query);

        try
        {
            if ($statement->execute($bindParams))
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