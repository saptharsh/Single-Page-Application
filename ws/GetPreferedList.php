<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';

    $dbConnection = new PDOExt();
    $utilities = new Utilities();

    $response = array();

    $user_id = $utilities->replaceDefault($_POST['user_id']);

    try
    {
        $query = "SELECT food_item.`name` AS food_name,
                        food_item.description,
                        food_item.ingredients,
                        food_item.nutrition,
                        food_item.preparation_method,
                        food_item.food_image_1,
                        food_item.food_image_2,
                        food_item.food_image_3,
                        food_item.food_image_4,
                        food_item.rating,
                        food_item.price,
                        CONCAT(chef.f_name, chef.l_name) AS chef_name,
                        chef.rating AS chef_rating,
                        chef.image_url
                FROM likes INNER JOIN food_item ON likes.food_item_id = food_item.item_id
                         INNER JOIN chef ON food_item.chef_id = chef.chef_id
                WHERE likes.user_id = '$user_id'";

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