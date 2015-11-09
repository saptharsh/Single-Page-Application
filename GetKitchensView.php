<br/>
<div style="margin: 0 auto; width: 95%;">
    <table id="kitchensDataTable" class="table-sort">
        <thead>
            <tr>
                <th width='10' class="table-sort">#</th>
                <th class="table-sort">Kitchen Name</th>
                <th class="table-sort">Area</th>
                <th class="table-sort">Pincode</th>
                <th class="table-sort">Lat,Lng</th>
                <th class="table-sort">Edit</th>
                <th class="table-sort">Delete</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
            <tr>
                <td align='center' colspan="7">
                    <a id='loading-kitchens' data-page-start='0' class='loadmore' href='#'> &nbsp;<i class="fa fa-spinner fa-pulse"></i>&nbsp; Loading...</a>
                </td>
            </tr>
        </tfoot>
    </table>
</div>

<style>
    #loading-kitchens{
        color: #ff8900;
    }
</style>

<script type="text/javascript">

    $(function () {
        /* $('table.table-sort').tablesort(); */
        loadKitchens();
    });

    function loadKitchens() {

        var footerId = $('#loading-kitchens');
        var tableEle = $("#kitchensDataTable > tbody");
        var rowCount = $("#kitchensDataTable > tbody > tr").length + 1;

        $.ajax({
            type: "POST",
            cache: false,
            url: "./ws/GetKitchen.php",
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
                                    "<td> " + (idx + 1) + " </td>" +
                                    "<td> " + obj.name + " </td>" +
                                    "<td> " + obj.area + " </td>" +
                                    "<td> " + obj.pincode + " </td>" +
                                    "<td align='center'> " + obj.latitude + "," + obj.longitude + " </td>" +
                                    "<td align='center'> <i class='fa fa-pencil fa-2x'></i> </td>" +
                                    "<td align='center'> <i class='fa fa-trash fa-2x'></i> </td>" +
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
