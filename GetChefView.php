<br/>
<div style="margin: 0 auto; width: 95%;">
    <span class="inner-text-title">Chef's</span>
    <table id="chefDataTable" class="table-sort  table-bordered table-striped">
        <thead>
            <tr>
                <th width='10' class="table-sort">#</th>
                <th class="table-sort">Image</th>
                <th class="table-sort">Chefs Name</th>
                <th class="table-sort">Phone Number</th>
                <th class="table-sort">Ratting</th>
                <th class="table-sort">Edit</th>
                <th class="table-sort">Delete</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
            <tr>
                <td align='center' colspan="7">
                    <a id='loading-chefs' data-page-start='0' class='loadmore' href='#'> &nbsp;<i class="fa fa-spinner fa-pulse"></i>&nbsp; Loading...</a>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
<button id="add-chef" title="Add new chef" class="fab">+</button>

<style>
    #loading-chefs{
        color: #ff8900;
    }
</style>
<div id="compose-form" class="compose-form-view" style=" display: none; width: 480px; height: 480px; background: #fff; z-index: 99;box-shadow: 0 0 5px rgba(0,0,0,0.2); position: fixed; bottom: 0; right: 15px;">
    <!--Header-->
    <div class="compose-form-header" style="width: 100%; background: #555; color: #fff; height: 40px; padding: 6px;">
        <span style="float: left;">Add chef</span>
        <span title="close" id="compose-form-close" style="float: right;cursor: pointer;"><i class="fa fa-times"></i></span>
    </div>
    <!--Form elements start here-->
    <div id="form-add-chef" style="margin: 10px;">
        <div class="div-row styleed-input">
            <div class="div-col">First name </div>
            <div><input type="text" name="f_name" id="f_name" placeholder="Chef's first name"/></div>
        </div>
        <div class="div-row styleed-input">
            <div class="div-col">Last name </div>
            <div><input type="text" name="l_name" id="l_name" placeholder="Last name" /></div>
        </div>
        <div class="div-row styleed-input">
            <div class="div-col">Country</div>
            <div><input type="text" name="country_code" id="country_code" placeholder="+91"  value="+91" disabled="true"/></div>
        </div>
        <div class="div-row styleed-input">
            <div class="div-col">Phone </div>
            <div><input type="text" name="phone_number" id="phone_number" placeholder="phone number"/></div>
        </div>
        <div class="div-row styleed-input">
            <div class="div-col">Image</div>
            <div><input type="file" accept="image/*" class="upload" name="image_url" id="image_url" placeholder="image"/></div>
        </div>
        <div class="div-row styleed-input">
            <div class="div-col">Rating</div>
            <div><input type="text" name="rating" id="rating" placeholder="rating"/></div>
        </div>

        <button id="compose-form-submit" class="material-button" style="left: 15px;">Add</button>
    </div>
</div>


<script type="text/javascript">

    $(function () {
        /* $('table.table-sort').tablesort(); */
        $('#compose-form').hide();
        loadChefs();


        $('#add-chef').click(function () {
            $('#compose-form').show(200);
        });

        $('#compose-form-close').click(function () {
            $('#compose-form').hide(200);
            $('#form-add-chef').find('input:text').val('');
        });

        $('#compose-form-submit').click(function () {
            submitForm();
        });

    });

    function deletechef(id){
        alert(id);
    }

    function submitForm() {

        var f_name = $('#f_name').val();
        var l_name = $('#l_name').val();
        var country_code = $('#country_code').val();
        var phone_number = $('#phone_number').val();
        var image_url = $('#image_url').val();//'http://icons.iconarchive.com/icons/iconshock/cook/256/cheff-icon.png';
        var rating = $('#rating').val();

        if (f_name.length > 0 && l_name.length > 0 && country_code.length > 0 && phone_number.length > 0 && image_url.length > 0 && rating.length > 0) {

            $.ajax({
                type: "POST",
                cache: false,
                url: "./ws/InsertChef.php",
                data: {
                    f_name: f_name,
                    l_name: l_name,
                    country_code: country_code,
                    phone_number: phone_number,
                    image_url: image_url,
                    rating: rating
                },
                beforeSend: function () {
                    $('#compose-form-submit').hide();
                },
                complete: function () {
                },
                success: function (jsonResp)
                {
                    var status = jsonResp.status;
                    var desc = jsonResp.desc;//desc- description

                    $('#loading-chefs').data('page-start', 0);
                    $('#compose-form').hide(200);
                    $('#form-add-chef').find('input:text').val('');
                    loadChefs(1);

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

    function loadChefs() {

        var footerId = $('#loading-chefs');
        var tableEle = $("#chefDataTable > tbody");
        tableEle.empty();
        var rowCount = $("#chefDataTable > tbody > tr").length + 1;

        $.ajax({
            type: "POST",
            cache: false,
            url: "./ws/GetChef.php",
            data: {
                page_start: footerId.data('page-start')
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
                            //$.each(obj, function (idx1, obj1) {
                            tableEle.append("<tr>" +
                                    "<td> " + (idx + rowCount) + " </td>" +
                                    "<td align='center'> <img class='round-shape' style='margin-top: 10px;' src='"
                                        + obj.chef_image_url + "' width='36' height='36'/> </td>" +
                                    "<td> " + obj.chef_name + " </td>" +
                                    "<td> " + obj.chef_phone_number + " </td>" +
                                    "<td align='center'> " + obj.rating + " </td>" +
                                    "<td align='center' > <i class='fa fa-pencil fa-1x'></i> </td>" +
                                    "<td align='center'> <i onclick = deletechef('"+obj.chef_id+"'); class='fa fa-trash fa-1x'></i> </td>" +
                                    "</tr>");
                        });

                        /*
                        if (data.length === -1) {
                            var pageStartUpdatedVal = footerId.data('page-start') + data.length;
                            footerId.data('page-start', pageStartUpdatedVal).html('Load More');
                        } else {
                            footerId.html('');
                        }
                        */
                       footerId.html('');
                    }
                    else {
                        tableEle.append("<tr>" + "<td align='center' colspan='7'> No Data to display </td>" + "</tr>");
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
