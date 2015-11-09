<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';
    include_once '../classes/MongoLogger.php';

    $dbConnection = new PDOExt();
    $utilities = new Utilities();
    $log = new MongoLogger(basename($_SERVER['PHP_SELF']));

    $response = array();

    $log->setPostReq($_POST);
    
    $name = $utilities->clean($_POST['name']);
    $description = $utilities->clean($_POST['description']);
    $ingredients = $utilities->clean($_POST['ingredients']);
    $preparation_method = $utilities->clean($_POST['preparation_method']);
    $nutrition = $utilities->clean($_POST['nutrition']);
    $food_image_1 = $utilities->clean($_POST['food_image_1']);
    $food_image_2 = $utilities->clean($_POST['food_image_2']);
    $food_image_3 = $utilities->clean($_POST['food_image_3']);
    $food_image_4 = $utilities->clean($_POST['food_image_4']);
    $food_image_5 = $utilities->clean($_POST['food_image_5']);
    $food_image_6 = $utilities->clean($_POST['food_image_6']);
    $rating = $utilities->replaceZero($_POST['rating']);
    $price = $utilities->replaceZero($_POST['price']);
    $currency_id = $utilities->replaceOne($_POST['currency_id']);
    $chef_id = $utilities->replaceZero($_POST['chef_id']);
    $category_id = $utilities->replaceOne($_POST['category_id']);

    $log_datetime = $utilities->replaceNow();

    $foodId = -1;

    try
    {
        $insertQuery = "INSERT INTO "
                . " `food_item` (name, description, ingredients, preparation_method, nutrition, food_image_1,food_image_2,food_image_3, food_image_4, food_image_5, food_image_6, rating, price, currency_id, chef_id, category_id, log_datetime) "
                . " VALUES ('$name', '$description', '$ingredients', '$preparation_method', '$nutrition', '$food_image_1', '$food_image_2','$food_image_3','$food_image_4','$food_image_5','$food_image_6', '$rating', '$price', '$currency_id', '$chef_id', '$category_id', '$log_datetime')";

        $log->info("Query:" . $insertQuery);
        $statement = $dbConnection->prepare($insertQuery);

        try
        {
            $dbConnection->beginTransaction();
            if ($statement->execute())
            {
                $foodId = $dbConnection->lastInsertId();
                $dbConnection->commit();

                $log->info("Inserted User successfully with id:" . $foodId);
                $response = array('status' => $foodId, 'desc' => 'Success');
            }
            else
            {
                $status = -99;
                $dbError = $statement->errorInfo();
                $log->error($dbError[2]);
                $response = array('status' => $status, 'desc' => 'DB error occured' . $dbError[2]);
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

    $log->endLogger();

    header("Content-type: application/json");
    echo json_encode($response);
?>
