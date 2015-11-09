<?php
    include_once './classes/PDOExt.php';
    $dbConnection = new PDOExt();
?>
<br/>
<div style="margin: 0 auto; width: 95%;">
    <table id="menuTable" class="table-sort">
        <thead>
            <tr>
                <th style="border-bottom:.12em solid rgb(240, 240, 240);" align='center' colspan="7">
                    <span style="font-size: 1.2em;" id='menu-date' data-date='<?php echo date('Y-m-d'); ?>'> <?php echo date('d M y'); ?> </span>
                </th>
            </tr>
            <tr>
                <th width='10' class="table-sort">#</th>
                <th class="table-sort">Serving</th>
                <th class="table-sort">Food Item Name</th>
                <th class="table-sort">Prepared For</th>
                <th class="table-sort">Orders Till Now</th>
                <th class="table-sort">Edit</th>
                <th class="table-sort">Delete</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
            <tr>
                <td align='center' colspan="7">
                    <a id='loading-menu' data-page-start='0' class='loadmore' href='#'> &nbsp;<i class="fa fa-spinner fa-pulse"></i>&nbsp; Loading data...</a>
                </td>
            </tr>
        </tfoot>
    </table>
</div>

<button id="add-menu" title="Add items for menu" class="fab">+</button>

<div id="compose-form" class="compose-form-view" style=" display: none; width: 480px; height: 480px; background: #fff; z-index: 99;box-shadow: 0 0 5px rgba(0,0,0,0.2); position: fixed; bottom: 0; right: 15px;">
    <!--Header-->
    <div class="compose-form-header" style="width: 100%; background: #555; color: #fff; height: 40px; padding: 6px;">
        <span style="float: left;">Add Menu</span>
        <span title="close" id="compose-form-close" style="float: right;cursor: pointer;"><i class="fa fa-times"></i></span>
    </div>
    <!--Form elements start here-->
    <div id="form-add-menu" style="margin: 10px;">
        <div class="div-row styleed-input">
            <div class="div-col">Item Food </div>
            <div>
                <select id='item_id'>
                    <?php
                        $dataFood = array();
                        try
                        {
                            $query = "SELECT item_id, food_item.`name` AS food_name
                                        FROM food_item
                                        ORDER BY food_item.name ASC;";
                            $statement = $dbConnection->prepare($query);

                            try
                            {
                                if ($statement->execute())
                                {
                                    $dataFood = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    $statement->closeCursor();
                                }
                                else
                                {
                                    $errorCode = -99;
                                    $dbError = $statement->errorInfo();
                                    $statement->closeCursor();
                                    echo 'DB error occured' . $dbError[2];
                                }
                            }
                            catch (PDOExecption $e)
                            {
                                $errorCode = -7;
                                $statement->closeCursor();
                                echo $error = "Exception: " . $e->getMessage();
                            }
                        }
                        catch (PDOExecption $e)
                        {
                            $errorCode = -8;
                            echo $error = "Exception: " . $e->getMessage();
                        }

                        foreach ($dataFood as $food)
                        {
                            echo "<option value='" . $food['item_id'] . "'>" . $food['food_name'] . "</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="div-row styleed-input">
            <div class="div-col">Served for</div>
            <div>
                <select id='serving_id'>
                    <?php
                        $dataServing = array();
                        try
                        {
                            $query = "SELECT serving_id, serving_name
                                        FROM serving
                                        ORDER BY serving_name ASC;";
                            $statement = $dbConnection->prepare($query);

                            try
                            {
                                if ($statement->execute())
                                {
                                    $dataServing = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    $statement->closeCursor();
                                }
                                else
                                {
                                    $errorCode = -99;
                                    $dbError = $statement->errorInfo();
                                    $statement->closeCursor();
                                    echo 'DB error occured' . $dbError[2];
                                }
                            }
                            catch (PDOExecption $e)
                            {
                                $errorCode = -7;
                                $statement->closeCursor();
                                echo $error = "Exception: " . $e->getMessage();
                            }
                        }
                        catch (PDOExecption $e)
                        {
                            $errorCode = -8;
                            echo $error = "Exception: " . $e->getMessage();
                        }

                        foreach ($dataServing as $serving)
                        {
                            echo "<option value='" . $serving['serving_id'] . "'>" . $serving['serving_name'] . "</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="div-row styleed-input">
            <div class="div-col">available for</div>
            <div><input type="text" name="available_for" id="available_for" placeholder="prepared for (count)"/></div>
        </div>

        <div class="div-row styleed-input">
            <div class="div-col">Menu for </div>
            <div><input type="text" name="date" id="date" placeholder="date in YYYY-mm-dd format" value="<?php echo date('Y-m-d'); ?>"/></div>
        </div>

        <button id="compose-form-submit" class="material-button" style="left: 15px;">Add</button>
    </div>
</div>

<style>
    #loading-menu{
        color: #ff8900;
    }
</style>

<script type="text/javascript">

    $(function () {
        /* $('table.table-sort').tablesort(); */
        $('#compose-form').hide();
        loadMenu();

        $('#add-menu').click(function(){
           $('#compose-form').show(200);
        });

        $('#compose-form-close').click(function () {
            $('#compose-form').hide(200);
            $('#form-add-menu').find('input:text').val('');
        });


        $('#compose-form-submit').click(function () {
            submit();
        });
    });

    function submit() {
        var item_id = $('#item_id').val();
        var serving_id = $('#serving_id').val();
        var available_for = $('#available_for').val();
        var date = $('#date').val();

        if (item_id.length > 0 && serving_id.length > 0 && available_for.length > 0 && date.length > 0) {

            $.ajax({
                type: "POST",
                cache: false,
                url: "./ws/InsertItemServingMapping.php",
                data: {
                    item_id: item_id,
                    serving_id: serving_id,
                    available_for: available_for,
                    date: date
                },
                beforeSend: function () {
                    $('#compose-form-submit').hide();
                },
                complete: function () {
                },
                success: function (jsonResp)
                {
                    var status = jsonResp.status;
                    var desc = jsonResp.desc;

                    $('#loading-menu').data('page-start', 0);
                    $('#compose-form').hide(200);
                    $('#form-add-menu').find('input:text').val('');

                    loadMenu();

                    if (status > 0) {
                        alertify.success(desc);
                    }
                    else {
                        alertify.error(desc);
                    }
                }
            });
        }
        else {
            alertify.error('Please verify you fields!');
        }
    }

    function loadMenu() {

        var footerId = $('#loading-menu');
        var tableEle = $("#menuTable > tbody");
        var rowCount = $("#menuTable > tbody > tr").length + 1;

        tableEle.empty();

        // console.log($('#menu-date').data('date'));
        $.ajax({
            type: "POST",
            cache: false,
            url: "./ws/GetMenu.php",
            data: {
                page_start: footerId.data('page-start'),
                date: $('#menu-date').data('date')
            },
            beforeSend: function () {
                footerId.html('&nbsp;<i class="fa fa-spinner fa-pulse"></i>&nbsp; Loading...');
            },
            complete: function () {
            },
            success: function (jsonResp)
            {
                var status = jsonResp.status;
                var data = jsonResp.data;
                var desc = jsonResp.desc;

                if (status === 0) {
                    if (data.length > 0) {
                        $.each(data, function (idx, obj) {
                            tableEle.append("<tr>" +
                                    "<td> " + (idx + rowCount) + " </td>" +
                                    "<td> " + obj.serving_name + " </td>" +
                                    "<td> " + obj.food_name + " </td>" +
                                    "<td align='center'> " + obj.available_for_count + " </td>" +
                                    "<td align='center'> " + obj.order_count + " </td>" +
                                    "<td align='center'> <i class='fa fa-pencil fa-2x'></i> </td>" +
                                    "<td align='center'> <i class='fa fa-trash fa-2x'></i> </td>" +
                                    "</tr>");
                        });

                        if (data.length === 25) {
                            var pageStartUpdatedVal = footerId.data('page-start') + data.length;
                            footerId.data('page-start', pageStartUpdatedVal).html('Load More');
                        } else {
                            footerId.html('');
                        }
                    }
                    else {
                        tableEle.append("<tr>" + "<td align='center' color='#e1e1e1' colspan='7'> No Data to display </td>" + "</tr>");
                        footerId.html('');
                    }
                }
                else {
                    alertify.error(desc);
                    footerId.html('');
                }

            }
        });
    }

</script>
