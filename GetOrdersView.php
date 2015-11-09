<br/>
<div style="margin: 0 auto; width: 99%;">
    <table id="orderTable" class="table-sort">
        <thead>
            <tr>
                <th width='10' class="table-sort">#</th>
                <th class="table-sort">User Name</th>
                <th class="table-sort">Order Items</th>
                <th class="table-sort">Delivery Address</th>
                <th width='50' class="table-sort">Time Slot</th>
                <th width='50' class="table-sort">Ordered Time</th>
                <th width='55' class="table-sort">Status</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
            <tr>
                <td align='center' colspan="7">
                    <a id='loading-orders' data-page-start='0' class='loadmore' href='#'> &nbsp;<i class="fa fa-spinner fa-pulse"></i>&nbsp; Loading...</a>
                </td>
            </tr>
        </tfoot>
    </table>
</div>

<style>
    #loading-orders{
        color: #ff8900;
    }
</style>

<script type="text/javascript">

    $(function () {
        /* $('table.table-sort').tablesort(); */
        loadChefs();
    });

    function loadChefs() {

        var footerId = $('#loading-orders');
        var tableEle = $("#orderTable > tbody");
        var rowCount = $("#orderTable > tbody > tr").length + 1;

        $.ajax({
            type: "POST",
            cache: false,
            url: "./ws/GetOrders.php",
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
                            tableEle.append("<tr>" +
                                    "<td> " + (idx + rowCount) + " </td>" +
                                    "<td> " + obj.user_name + "<br/>" + obj.user_phone_number + " </td>" +
                                    "<td> " + obj.basket_code + "<br/>" + obj.item_quantity_price_json + " </td>" +
                                    "<td> " + obj.street_address + "<br/>" + obj.city + "<br/>" + obj.state + "<br/>" + obj.country + "<br/>" + obj.pincode + " <br/> " + obj.delivery_address_phone_number + "<br/>Near: " + obj.landmark + "</td>" +
                                    "<td> " + obj.time_slot_name + " </td>" +
                                    "<td> " + obj.order_placed_datetime + " </td>" +
                                    "<td> " + obj.status + " </td>" +
                                    "</tr>");
                        });

                        if (data.length === 5) {
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
