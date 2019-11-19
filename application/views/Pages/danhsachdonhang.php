<div class="container bill-heading pt-5">
    <h1>Danh Sách Đơn Hàng</h1>
    <hr/>
</div>
<div class="container bill-list pt-1">
    <table class="table table-bordered text-center" style="box-shadow: 3px 3px 10px gray">
        <thead>
            <tr style="background-color: #3b9f5e; color: #fff">
                <th>Mã Đơn Hàng</th>
                <th>Ngày Đặt</th>
                <th>Tổng Tiền</th>
                <th>Trạng Thái</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($bills as $item){
                $status = "";
                if($item["status"] == 0){
                    $status = "Thành Công";
                }else if($item["status"] == 1){
                    $status = "Chờ Xác Nhận";
                }else{
                    $status = "Đã Hủy";
                }
            ?>
                <tr id="id<?php echo $item["id_bills"] ?>">
                    <td><?php echo $item["id_bills"]  ?></td>
                    <td><?php echo date('d-m-Y H:i:s',strtotime($item["create_at"]))   ?></td>
                    <td><?php echo number_format($item["total"])  ?> đ</td>
                    <td><?php echo $status  ?></td>
                    <td><button class="btn btn-success" onclick="getDetailBill(<?php echo $item["id_bills"] ?>)" data-toggle="modal" data-target="#exampleModal">Xem Chi Tiết</button></td>
                </tr>
            
            <?php }?>
        </tbody>
    </table>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog detailbillstyle" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Chi Tiết Hóa Đơn</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered text-center" style="box-shadow: 3px 3px 10px gray">
                        <thead>
                            <tr style="background-color: #3b9f5e; color: #fff">
                                <th colspan="2">Sản Phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Thành Tiền</th>
                            </tr>
                        </thead>
                        <tbody id="detailbilldata">
                            
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
    </div>
    </div>
</div>
<style>
    .detailbillstyle{
        max-width: 80%;
    }
</style>
<script>
    function getDetailBill($idbill){
       $("#detailbilldata").children().remove();
       $.ajax({
            url: '<?php echo base_url() ?>Handling/getdetailbill',
            type: 'POST',
            dataType: 'json',
            data: {
                idbill: $idbill
            }
        }).done(function(data){
            
            for (var detail of data) {
                renderDetail(detail);
            }
        })
    }
    function renderDetail(detail){
        $item = $('<tr><td>'+detail.name+'</td><td><image width="100px" src="<?php echo base_url() ?>public/images/products/'+detail.image+'" /></td><td>'+formatCurrency(detail.price)+' đ</td><td>'+detail.quantum+'</td><td>'+formatCurrency(detail.money)+' đ</td></tr>');
        $dataposition = $("#detailbilldata");
        $dataposition.append($item);
    }
    function formatCurrency(number){
        var n = number.split('').reverse().join("");
        var n2 = n.replace(/\d\d\d(?!$)/g, "$&,");    
        return  n2.split('').reverse().join('');
    }
</script>
