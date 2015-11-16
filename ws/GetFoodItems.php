<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';
    //include_once '../classes/MongoLogger.php';
    include_once '../classes/Logger.php';

    $dbConnection = new PDOExt();
    $utilities = new Utilities();
    //$log = new MongoLogger(basename($_SERVER['PHP_SELF']));
    $log = new Logger(basename($_SERVER['PHP_SELF']));

    $response = array();

    $log->arrayLogger($_POST, "POST Req Data");
    $item_per_page      = 5; //item to display per page
    //$page_start = $utilities->replaceZero($_POST['page_start']);
    if(isset($_POST['page_index'])){
        $page_start = $_POST['page_index'];
        
        $page_position = (($page_start-1) * $item_per_page);
    } else {
        $page_position = $utilities->replaceZero($_POST['page_start']);
    }
    $chef_id = $utilities->replaceDefault($_POST['chef_id']);
    

    $dateTime = $utilities->replaceNow();

    //print_r($_POST);
    try
    {
        $query = " SELECT food_item.item_id,
                        food_item.`name` AS food_name,
                        food_item.description,
                        food_item.ingredients,
                        food_item.preparation_method,
                        food_item.rating AS food_rating,
                        category.category_id,
                        category.category_name,
                        food_item.price,
                        currency.currency_id,
                        currency.currency_name,
                        currency.currency_symbol,
                        chef.chef_id,
                        CONCAT(chef.f_name, ' ', chef.l_name) AS chef_name,
                        CONCAT(chef.country_code, chef.phone_number) AS chef_phone_number,
                        chef.image_url AS chef_image,
                        chef.rating AS chef_rating,
                        food_item.nutrition,
                        COALESCE(food_item.food_image_1, '') AS food_image_1,
                        COALESCE(food_item.food_image_2, '') AS food_image_2,
                        COALESCE(food_item.food_image_3, '') AS food_image_3,
                        COALESCE(food_item.food_image_4, '') AS food_image_4,
                        food_item.log_datetime
                FROM food_item INNER JOIN category ON food_item.category_id = category.category_id
                         INNER JOIN currency ON food_item.currency_id = currency.currency_id
                         INNER JOIN chef ON food_item.chef_id = chef.chef_id ";
        $query .= ($chef_id > 0) ? " WHERE food_item.chef_id = $chef_id " : " ";
        $query .= " ORDER BY food_name ASC
                LIMIT $page_position, $item_per_page;";
        //echo $query;
        $log->info("Query:" . $query);
        $statement = $dbConnection->prepare($query);

        try
        {
            if ($statement->execute($bindParams))
            {
                $data = $statement->fetchAll(PDO::FETCH_ASSOC);
                $statement->closeCursor();

                $log->arrayMultiLogger($data, 'Result for food items');

                $response = array('status' => 0, 'data' => $data, 'desc' => 'success','index' => $page_start);
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

    header("Content-type: application/json; charset=utf-8");
    echo json_encode($response);
?>