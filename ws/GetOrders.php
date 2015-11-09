<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';
    include_once '../classes/MongoLogger.php';

    $dbConnection = new PDOExt();
    $utilities = new Utilities();
    $log = new MongoLogger(basename($_SERVER['PHP_SELF']));

    $response = array();

    $log->setPostReq($_POST);
    $page_start = $utilities->replaceZero($_POST['page_start']);
    $order_date = $utilities->replaceToday($_POST['order_date']);
    $flag_category = $utilities->replaceZero($_POST['flag_category']);

    try
    {
        $query = "SELECT `order`.basket_code,
                        `user`.user_id,
                        CONCAT(`user`.f_name, ' ', `user`.l_name) AS user_name,
                        CONCAT(`user`.country_code, `user`.phone_number) AS user_phone_number,
                        `user`.image_url AS user_image_url,
                        `order`.item_quantity_price_json,
                        `order`.date,
                        `order`.flag_category,
                        address.street_address,
                        address.landmark,
                        address.city,
                        address.state,
                        address.country,
                        address.pincode,
                        CONCAT(address.country_code, address.phone_number) AS delivery_address_phone_number,
                        time_slot.time_slot_name,
                        time_slot.time_slot_start,
                        time_slot.time_slot_end,
                        `order`.log_datetime AS order_placed_datetime,
                        `status`.status_id,
                        `status`.`status`
                FROM `order` INNER JOIN `user` ON `order`.user_id = `user`.user_id
                         INNER JOIN address ON `order`.address_id = address.address_id
                         INNER JOIN time_slot ON `order`.time_slot_id = time_slot.time_slot_id
                         INNER JOIN `status` ON `order`.`status` = `status`.status_id
                WHERE `order`.date = '$order_date'";
        $query .= ($flag_category == 0 ) ? "" : " AND flag_category = '$flag_category' ";
        $query .= "ORDER BY order_placed_datetime DESC
                LIMIT $page_start, 25";

        $log->info("Query:" . $query);
        $statement = $dbConnection->prepare($query);

        try
        {
            if ($statement->execute($bindParams))
            {
                $data = $statement->fetchAll(PDO::FETCH_ASSOC);
                $statement->closeCursor();

                $log->arrayMultiLogger($data, 'Result for deals');

                $response = array('status' => 0, 'data' => $data, 'desc' => 'success');
            }
            else
            {
                $errorCode = -99;
                $dbError = $statement->errorInfo();
                $statement->closeCursor();
                $log->error($dbError[2]);
                $response = array('status' => $errorCode, 'data' => array(), 'desc' => 'DB error occured' . $dbError[2]);
            }
        }
        catch (PDOExecption $e)
        {
            $errorCode = -7;
            $statement->closeCursor();
            $error = "Exception: " . $e->getMessage();
            $log->error($error);
            $response = array('status' => $errorCode, 'data' => array(), 'desc' => 'PDO exception occured' . $error);
        }
    }
    catch (PDOExecption $e)
    {
        $errorCode = -8;
        $error = "Exception: " . $e->getMessage();
        $log->error($error);
        $response = array('status' => $errorCode, 'data' => array(), 'desc' => 'PDO exception occured' . $error);
    }

    $log->endLogger();

    header("Content-type: application/json");
    echo json_encode($response);
?>