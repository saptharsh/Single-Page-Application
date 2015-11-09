<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';
    include_once '../classes/MongoLogger.php';

    $dbConnection = new PDOExt();
    $utilities = new Utilities();
    $log = new MongoLogger(basename($_SERVER['PHP_SELF']));

    $response = array();

    $log->setPostReq($_POST);

    $serving_id = $utilities->replaceDefault($_POST['serving_id']);
    $date = $utilities->replaceToday($_POST['date']);
    
    $userId = $utilities->replaceZero($_POST['user_id']);

    try
    {
        $query = "SELECT food_item.item_id AS food_id,
                        food_item.`name` AS food_name,
                        food_item.description AS food_description,
                        food_item.ingredients AS food_ingredients,
                        food_item.preparation_method AS food_preparation_method,
                        food_item.rating AS food_rating,
                        food_item.price AS food_price,
                        COALESCE(food_item.food_image_1, '') AS food_image_1,
                        COALESCE(food_item.food_image_2, '') AS food_image_2,
                        COALESCE(food_item.food_image_3, '') AS food_image_3,
                        COALESCE(food_item.food_image_4, '') AS food_image_4,
                        food_item.category_id,
                        currency.currency_symbol AS food_currency_symbol,
                        food_item.chef_id,
                        CONCAT(chef.f_name, ' ', chef.l_name) AS chef_name,
                        chef.image_url AS chef_image_url,
                        chef.rating AS chef_rating,
                        serving.serving_name,
                        item_serving_mapping.available_for AS available_for_count,
                        item_serving_mapping.order_count,
                        item_serving_mapping.date AS serving_date,
                        (SELECT COUNT(*) FROM `likes` WHERE food_item_id = food_id) AS likes_count,
                        (SELECT COUNT(*) FROM `likes` WHERE food_item_id = food_id AND likes.user_id = '$userId' ) AS liked_already,
                        category.category_id,
                        category.category_name
                FROM item_serving_mapping INNER JOIN food_item ON item_serving_mapping.item_id = food_item.item_id
                         INNER JOIN category ON food_item.category_id = category.category_id
                         INNER JOIN currency ON food_item.currency_id = currency.currency_id
                         INNER JOIN chef ON food_item.chef_id = chef.chef_id
                         INNER JOIN serving ON item_serving_mapping.serving_id = serving.serving_id ";
        $query .= " WHERE (item_serving_mapping.date = '$date'  OR item_serving_mapping.date = '1970-01-01') ";
        $query .= ($serving_id > 0) ? " AND item_serving_mapping.serving_id = $serving_id " : " ";
        $query .= "ORDER BY item_serving_mapping.serving_id ASC, food_rating ASC, food_name ASC";

        $log->info("Query:" . $query);
        $statement = $dbConnection->prepare($query);

        try
        {
            if ($statement->execute($bindParams))
            {
                $data = $statement->fetchAll(PDO::FETCH_ASSOC);
                $statement->closeCursor();

                $log->arrayMultiLogger($data, 'Result for menu');

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