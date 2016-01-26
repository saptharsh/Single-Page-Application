<?php

    include_once '../classes/PDOExt.php';
    include_once '../classes/Utilities.php';

    $dbConnection = new PDOExt();
    $utilities = new Utilities();

    $response = array();

    $bill_code = uniqid("BILL_");
    $bill_pay_through = $utilities->clean($_POST['bill_pay_through']);
    $bill_date = $utilities->replaceToday($_POST['bill_date']);
    $bill_discount = $utilities->clean($_POST['bill_discount']);
    $bill_total_amount = $utilities->clean($_POST['bill_total_amount']);
    $user_name = $utilities->clean($_POST['user_name']);
    $user_email = $utilities->clean($_POST['user_email']);
    $user_phone_number = $utilities->clean($_POST['user_phone_number']);
    $use_delivery_address = $utilities->clean($_POST['use_delivery_address']);
    $basket_code = $utilities->clean($_POST['basket_code']);
    $item_quantity_price_json = $utilities->clean($_POST['item_quantity_price_json']);
    $is_bill_payed = $utilities->replaceZero($_POST['is_bill_payed']);

    $log_datetime = $utilities->replaceNow();

    //Calculating bill amount...
    $basketQunatityArray = array();
    $totalAmount = 0;
    $bill_item_count = 0;
    $orderJSONArray = json_decode($item_quantity_price_json);
    foreach ($orderJSONArray as $foodItem)
    {
        $subTotalPrice = $foodItem['qunatity'] * $foodItem['price'];
        $bill_item_count++;

        array_push($basketQunatityArray, array(
            'item_name' => $foodItem['name'],
            'qunatity' => $foodItem['qunatity'],
            'unit_price' => $foodItem['price'],
            'sub_total_price' => $subTotalPrice
        ));

        $totalAmount += $subTotalPrice;
    }
    $bill_amount = $totalAmount;
    $item_quantity_bill_json = json_encode($basketQunatityArray);

    $billId = -1;

    try
    {
        $insertQuery = "INSERT INTO "
                . " `bill` (bill_code, bill_amount, bill_discount, bill_total_amount, bill_item_count, bill_pay_through, bill_date, user_name, user_email, user_phone_number, use_delivery_address, basket_code, item_quantity_bill_json, is_bill_payed, log_datetime) "
                . " VALUES ('$bill_code', '$bill_amount', '$bill_discount','$bill_total_amount','$bill_item_count','$bill_pay_through', '$bill_date', '$user_name', '$user_email', '$user_phone_number', '$use_delivery_address', '$basket_code', '$item_quantity_bill_json', '$is_bill_payed','$log_datetime')";
    
        $statement = $dbConnection->prepare($insertQuery);

        try
        {
            $dbConnection->beginTransaction();
            if ($statement->execute())
            {
                $billId = $dbConnection->lastInsertId();
                $dbConnection->commit();
    
                $response = array('status' => $billId, 'desc' => 'Success');
            }
            else
            {
                $status = -99;
                $dbError = $statement->errorInfo();
    
                $response = array('status' => $status, 'desc' => 'DB error occured' . $dbError[2]);
            }
        }
        catch (PDOExecption $e)
        {
            $status = -7;
            $error = "Exception: " . $e->getMessage();
    
            $response = array('status' => $status, 'desc' => 'PDO exception occured' . $error);
        }

        $statement->closeCursor();
    }
    catch (PDOExecption $e)
    {
        $status = -8;
        $error = "Exception: " . $e->getMessage();
    
        $response = array('status' => $status, 'desc' => 'PDO exception occured' . $error);
    }

    header("Content-type: application/json");
    echo json_encode($response);
?>
