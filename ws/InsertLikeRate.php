<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';
    include_once '../classes/MongoLogger.php';

    $dbConnection = new PDOExt();
    $utilities = new Utilities();
    $log = new MongoLogger(basename($_SERVER['PHP_SELF']));

    $response = array();

    $log->setPostReq($_POST);

    $food_item_id = $utilities->clean($_POST['food_id']);
    $user_id = $utilities->clean($_POST['user_id']);
    $rating = $utilities->replaceZero($_POST['rating']);
    $review = $utilities->replaceZero($_POST['review']);
    $review_detail = $utilities->replaceZero($_POST['review_detail']);

    $log_datetime = $utilities->replaceNow();

    $likeId = -1;

    $dataReviewd = array();

    try
    {
        $query = "SELECT COUNT(*) AS is_reviewed
                FROM `likes`
                WHERE user_id = '$user_id'
                    AND food_item_id = '$food_item_id';";

        $log->info("Query:" . $query);
        $statement = $dbConnection->prepare($query);

        try
        {
            if ($statement->execute($bindParams))
            {
                $dataReviewd = $statement->fetchAll(PDO::FETCH_ASSOC);
                $statement->closeCursor();

                $log->arrayMultiLogger($data, 'Result for is reviewd query');
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

    if ($dataReviewd[0]['is_reviewed'] == 0)
    {

        try
        {

            $insertQuery = "INSERT INTO "
                    . " `likes` (food_item_id, user_id, rating, review, review_detail, log_datetime) "
                    . " VALUES ('$food_item_id', '$user_id', '$rating', '$review', '$review_detail', '$log_datetime')";

            $log->info("Query:" . $insertQuery);
            $statement = $dbConnection->prepare($insertQuery);

            try
            {
                $dbConnection->beginTransaction();
                if ($statement->execute())
                {
                    $likeId = $dbConnection->lastInsertId();
                    $dbConnection->commit();

                    $log->info("Inserted like and rating successfully with id:" . $likeId);
                    $response = array('status' => $likeId, 'desc' => 'Success');
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
    }
    else
    {
        $response = array('status' => 0, 'desc' => 'Already reviewed');
    }

    $log->endLogger();

    header("Content-type: application/json");
    echo json_encode($response);
?>
