<?php
    include_once './classes/PDOExt.php';
    $dbConnection = new PDOExt();
?>
<style>
    #loading-food-items{color: #ff8900; }
</style>
<br/>
<div style="margin: 0 auto; width: 95%;">
    <table id="foodItemsDataTable" class="table-sort table-bordered table-striped">
        <thead>
            <tr>
                <th width='10' class="table-sort">#</th>
                <th class="table-sort">Food Name</th>
                <th class="table-sort">Category</th>
                <th class="table-sort">Energy</th>
                <th class="table-sort">Price</th>
                <th class="table-sort">Rating</th>
                <th class="table-sort">Prepared By</th>
                <th class="table-sort">Edit</th>
                <th class="table-sort">Delete</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
            <tr>
                <td align='center' colspan="9">
                    <a id='loading-food-items' data-page-start='0' class='loadmore' href='#'> &nbsp;<i class="fa fa-spinner fa-pulse"></i>&nbsp; Loading...</a>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
<button id="add-food" title="Add food item" class="fab">+</button>


<?php
$item_per_page = 5;
$page_number = 1;
$get_total_rows[0] = 16;
$total_pages = 4;

echo '<div align="center">';
// To generate links, we call the pagination function here. 
echo paginate_function($item_per_page, $page_number, $get_total_rows[0], $total_pages);
echo '</div>';


function paginate_function($item_per_page, $current_page, $total_records, $total_pages)
{
    $pagination = '';
    if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
        $pagination .= '<ul class="pagination">';
        
        $right_links    = $current_page + 3; 
        $previous       = $current_page - 3; //previous link 
        $next           = $current_page + 1; //next link
        $first_link     = true; //boolean var to decide our first link
    
        echo 'current_page = 1: '.'previous link(current_page - 3): '.$previous.' next link(current_page + 1): '.$next.' right links(current_page + 3): '.$right_links.'<br/>';
        
        if($current_page > 1){
            $previous_link = ($previous==0)?1:$previous;
        
            echo 'For creating < and <<<br/>';
            echo 'current_page > 1: '.'previous link(current_page - 3): '.$previous_link.' next link(current_page + 1): '.$next.' right links(current_page + 3): '.$right_links.'<br/>';
            
            $pagination .= '<li class="first"><a href="#" data-page="1" title="First">&laquo;</a></li>'; //first link
            $pagination .= '<li><a href="#" data-page="'.$previous_link.'" title="Previous">&lt;</a></li>'; //previous link
            
            echo 'LEFT LINKS CREATION<br/>';
            echo 'current_page before For loop: '.$current_page.'<br/>';
                for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
                    
                    echo 'Outside If loop: '.$i.'<br/>';
                    if($i > 0){
                        echo 'In If loop: '.$i.'<br/>';
                        $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page'.$i.'">'.$i.'</a></li>';
                        echo ' '.'data-page = '.$i.'<br/>';
                    }
                }   
            $first_link = false; //set first link to false
        }
        
        // Only works for the first page
        if($first_link){ //if current active page is first link
            echo 'current page(first): '.$current_page.'<br/>';
            $pagination .= '<li class="first active">'.$current_page.'</li>';
        }elseif($current_page == $total_pages){ //if it's the last active link
            echo 'current page(last): '.$current_page;
            $pagination .= '<li class="last active">'.$current_page.'</li>';
        }else{ //regular current link
            echo 'current page(can\'t be first/last): '.$current_page;
            $pagination .= '<li class="active">'.$current_page.'</li>';
        }
        
        echo 'RIGHT LINKS CREATION<br/>';
        echo 'Before for loop(# of right links): '.$right_links.'<br/>';
        for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
            
            echo 'Before If loop: '.$i.'<br/>';
            if($i<=$total_pages){
                echo 'In If loop: '.$i.'<br/>';
                $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page '.$i.'">'.$i.'</a></li>';
            }
        }
        if($current_page < $total_pages){ 
                echo 'Form where is this $i coming? '.$i.' I guess after index goes out of bound from for loop<br/>';
                $next_link = ($i > $total_pages)? $total_pages : $i;
                echo 'For creating > and >><br/>';
                $pagination .= '<li><a href="#" data-page="'.$next_link.'" title="Next">&gt;</a></li>'; //next link
                $pagination .= '<li class="last"><a href="#" data-page="'.$total_pages.'" title="Last">&raquo;</a></li>'; //last link
        }
        
        $pagination .= '</ul>'; 
    }
    return $pagination; //return pagination links
}














?>













<div id="compose-form" class="compose-form-view" style="display: none;  overflow-y: auto; width: 480px; height: 480px; background: #fff; z-index: 99;box-shadow: 0 0 5px rgba(0,0,0,0.2); position: fixed; bottom: 0; right: 15px;">
    <!--Header-->
    <div class="compose-form-header" style="width: 100%; background: #555; color: #fff; height: 40px; padding: 6px;">
        <span style="float: left;">Add Food</span>
        <span title="close" id="compose-form-close" style="float: right;cursor: pointer;"><i class="fa fa-times"></i></span>
    </div>
    <!--Form elements start here-->
    <div id="form-add-chef" style="margin: 10px;">
        <div class="div-row styleed-input">
            <div class="div-col">Food name </div>
            <div><input type="text" name="name" id="name" placeholder="Food name"/></div>
        </div>
        <div class="div-row styleed-input">
            <div class="div-col">Description</div>
            <div><textarea name="description" id="description" placeholder="description" /></div>
        </div>
        <div class="div-row styleed-input">
            <div class="div-col">Ingredients</div>
            <div><textarea name="ingredients" id="ingredients" placeholder="ingredients"/></div>
        </div>
        <div class="div-row styleed-input">
            <div class="div-col">Preparation method</div>
            <div><textarea name="preparation_method" id="preparation_method" placeholder="preparation method"/></div>
        </div>
        <div class="div-row styleed-input">
            <div class="div-col">Energy Kcal </div>
            <div><input type="text" name="nutrition" id="nutrition" placeholder="Energy in kcal"/></div>
        </div>
        <div class="div-row styleed-input">
            <div class="div-col">Image 1</div>
            <div><input type="file" accept="image/*" class="upload" name="food_image_1" id="food_image_1" placeholder="food image 1"/></div>
        </div>
        <div class="div-row styleed-input">
            <div class="div-col">Image 2</div>
            <div><input type="file" accept="image/*" class="upload" name="food_image_2" id="food_image_2" placeholder="food image 2"/></div>
        </div>
        <div class="div-row styleed-input">
            <div class="div-col">Image 3</div>
            <div><input type="file" accept="image/*" class="upload" name="food_image_3" id="food_image_3" placeholder="food image 3"/></div>
        </div>
        <div class="div-row styleed-input">
            <div class="div-col">Image 4</div>
            <div><input type="file" accept="image/*" class="upload" name="food_image_4" id="food_image_4" placeholder="food image 4"/></div>
        </div>
        <div class="div-row styleed-input">
            <div class="div-col">price</div>
            <div>
                <input type="text" name="price" id="price" placeholder="price in Rs"/>
                <input type="hidden" name="currency_id" id="currency_id" value='1'/>
            </div>
        </div>
        <div class="div-row styleed-input">
            <div class="div-col">Chef</div>
            <div>
                <select id='chef_id'>
                    <?php
                        $dataChefs = array();
                        try
                        {
                            $query = "SELECT chef.chef_id, CONCAT(chef.f_name, ' ', chef.l_name) AS chef_name
                                        FROM chef
                                        ORDER BY chef.f_name ASC;";

                            $statement = $dbConnection->prepare($query);

                            try
                            {
                                if ($statement->execute($bindParams))
                                {
                                    $dataChefs = $statement->fetchAll(PDO::FETCH_ASSOC);
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

                        foreach ($dataChefs as $chef)
                        {
                            echo "<option value='" . $chef['chef_id'] . "'>" . $chef['chef_name'] . "</option>";
                        }
                    ?>
                </select>
            </div>
        </div>

        <div class="div-row styleed-input">
            <div class="div-col">Category</div>
            <div>
                <select id='category_id'>
                    <?php
                        $dataCategory = array();
                        try
                        {
                            $query = "SELECT category_id, category_name
                                        FROM category
                                        ORDER BY category_name ASC;";

                            $statement = $dbConnection->prepare($query);

                            try
                            {
                                if ($statement->execute($bindParams))
                                {
                                    $dataCategory = $statement->fetchAll(PDO::FETCH_ASSOC);
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

                        foreach ($dataCategory as $category)
                        {
                            echo "<option value='" . $category['category_id'] . "'>" . $category['category_name'] . "</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="div-row styleed-input">
            <div class="div-col">Food Rating</div>
            <div><input type="text" name="rating" id="rating" placeholder="rating"/></div>
        </div>

        <button id="compose-form-submit" class="material-button" style="left: 15px;">Add</button>
    </div>
</div>


<script type="text/javascript">
var records = 0;
    $(function () {
        /* $('table.table-sort').tablesort(); */
        $('#compose-form').hide();
        loadFoodItems(0);

        $('#add-food').click(function () {
            $('#compose-form').show(200);
        });

        $('#compose-form-close').click(function () {
            $('#compose-form').hide(200);
            $('#form-add-chef').find('input:text').val('');
        });

        $('#loading-food-items').click(function () {
            loadFoodItems(-1);
        });

        $('#compose-form-submit').click(function () {
            submitfood();
        });
    });

    function submitfood() {


        var name = $('#name').val();
        var description = $('#description').val();
        var ingredients = $('#ingredients').val();
        var preparation_method = $('#preparation_method').val();
        var nutrition = $('#nutrition').val();
        var price = $('#price').val();
        var food_image_1 = 'http://icons.iconarchive.com/icons/iconshock/cook/256/cheff-icon.png';//$('#food_image_1').val();
        var food_image_2 = 'http://icons.iconarchive.com/icons/iconshock/cook/256/cheff-icon.png';//$('#food_image_2').val();
        var food_image_3 = 'http://icons.iconarchive.com/icons/iconshock/cook/256/cheff-icon.png';//$('#food_image_3').val();
        var food_image_4 = 'http://icons.iconarchive.com/icons/iconshock/cook/256/cheff-icon.png';//$('#food_image_4').val();
        var rating = $('#rating').val();
        var currency_id = $('#currency_id').val();
        var chef_id = $('#chef_id').val();
        var category_id = $('#category_id').val();

        if (name.length > 0 &&
                description.length > 0 &&
                ingredients.length > 0 &&
                preparation_method.length > 0 &&
                nutrition.length > 0 &&
                price.length > 0 &&
                food_image_1.length > 0 &&
                food_image_2.length > 0 &&
                food_image_3.length > 0 &&
                food_image_4.length > 0 &&
                rating.length > 0 &&
                currency_id.length > 0 &&
                chef_id.length > 0 &&
                category_id.length > 0) {

            $.ajax({
                type: "POST",
                cache: false,
                url: "./ws/InsertFoodItem.php",
                data: {
                    name: name,
                    description: description,
                    ingredients: ingredients,
                    preparation_method: preparation_method,
                    nutrition: nutrition,
                    price: price,
                    food_image_1: food_image_1,
                    food_image_2: food_image_2,
                    food_image_3: food_image_3,
                    food_image_4: food_image_4,
                    rating: rating,
                    currency_id: currency_id,
                    chef_id: chef_id,
                    category_id: category_id
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

                    $('#loading-chefs').data('page-start', 0);
                    $('#compose-form').hide(200);
                    $('#form-add-chef').find('input:text').val('');
                    loadChefs(0);

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

    
    function loadFoodItems(startIdx) {

        var footerId = $('#loading-food-items');
        var tableEle = $("#foodItemsDataTable > tbody");
        var rowCount = $("#foodItemsDataTable > tbody > tr").length + 1;

        if (startIdx === 0) {
            footerId.data('page-start', 0);
        }

        $.ajax({
            type: "POST",
            cache: false,
            url: "./ws/GetFoodItems.php",
            data: {
                page_start: footerId.data('page-start')
            },
            beforeSend: function () {
                footerId.html('&nbsp;<i class="fa fa-spinner fa-pulse"></i>&nbsp; Loading...');
            },
            success: function (jsonResp)
            {
                var status = jsonResp.status;
                var data = jsonResp.data;
                var desc = jsonResp.desc;
                
                records = data.length;
                
                
                console.log(data);
                if (status === 0) {
                    if (data.length > 0) {
                        $.each(data, function (idx, obj) {
                            tableEle.append("<tr>" +
                                    "<td> " + (rowCount + idx) + " </td>" +
                                    "<td> " + obj.food_name + " </td>" +
                                    "<td> " + obj.category_name + " </td>" +
                                    "<td> " + obj.nutrition + " </td>" +
                                    "<td align='center'> " + obj.currency_symbol + " " + obj.price + " </td>" +
                                    "<td align='center'> " + obj.food_rating + " </td>" +
                                    "<td align='center'> " + obj.chef_name + " </td>" +
                                    "<td align='center'> <i class='fa fa-pencil fa-2x'></i> </td>" +
                                    "<td align='center'> <i class='fa fa-trash fa-2x'></i> </td>" +
                                    "</tr>");
                        });
                        
                        /*
                        if (data.length === 25) {
                            var pageStartUpdatedVal = footerId.data('page-start') + data.length;
                            footerId.data('page-start', pageStartUpdatedVal).html('Load More');
                        } else {
                            footerId.html('');
                        }
                        */
                       footerId.html('');
                       
                       value(records);
                    }
                    else {
                        tableEle.append("<tr>" + "<td align='center' colspan='9'> No Data to display </td>" + "</tr>");
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
    
    function value(test) {
    
        console.log('the value '+ test);
    }
    

</script>







