<div class="products-heading">
    <h1><i class="fas fa-shopping-bag"></i>Đơn Hàng</h1>
</div>
<div class="list-products">
    <table class="table table-bordered text-center" id="table_id">
        <thead style="background-color: #3b9f5e;">
            <th>ID Bill</th>
            <th>Họ Tên</th>
            <th>Số Điện Thoại</th>
            <th>Địa Chỉ</th>
            <th>Tổng Tiền</th>
            <th>Trạng Thái</th>
            <th>Ngày Đặt</th>
            <th></th>
        </thead>
        <tbody>
        <?php foreach($bills as $i){ ?>
        <tr id="id<?php echo $i["id_bills"] ?>">
            <td><?php echo $i["id_bills"] ?></td>
            <td><?php echo $i["cusName"]?></td>
            <td><?php echo $i["phonenumber"]?></td>
            <td><?php echo $i["address"]?></td>
            <td><?php echo number_format($i["total"])?></td>
            <td><?php echo $i["status"] == 1 ? "Đã Hủy" : "Đã Giao"?></td>
            <td><?php echo $i["create_at"]?></td>
            <td>
                <button onclick="detail(<?php echo $i["id_bills"] ?>)" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Chi Tiết</button>
            </td>
        </tr>
        <?php } ?>
        </tbody> 
    </table>
</div>
<style>
    .products-heading{
        padding-top: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid gray;
        display: flex;
        justify-content: space-between;
        padding-right: 20px;
    }
    .products-heading i{
        margin-right: 20px;
    }
    .products-heading h1{
        font-size: 30px;
    }
    .list-products{
        padding-top: 20px;
        padding-right: 20px;
    }
</style>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Chi tiết đơn hàng</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="list-products">
            <table class="table table-bordered text-center" id="table_ct">
                <thead style="background-color: #3b9f5e;">
                    <th>ID Sản Phẩm</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Số Lượng</th>
                    <th>Tổng Tiền</th>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                    </tr>
                </tbody> 
            </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<style>
    .modal-update{
        background : rgba(0,0,0,0.7);
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow-y: auto;
        z-index: 1001;
    }
    .modal-update::-webkit-scrollbar{
        display: none;
    }
    .modal-update-bg{
        width: 600px;
        background-color: #fff;
        border: 1px solid green;
        padding: 20px;
        border-radius: 10px;
        margin: 20px auto;
    }
    .modal-update-bg h2{
        font-size: 25px;
    }
    .modal-update-button{
        display: flex;
        justify-content: flex-end;
        padding-top: 20px;
    }
    .modal-update-button button{
        margin-left: 10px;
    }
    .modal-update-content label{
        padding-left: 10px;
        padding-right: 20px;
    }
    .modal-update-content input, .modal-update-content select{
        margin-bottom: 10px;
    }
</style>
<style>
    .modal .modal-dialog{
        max-width: 600px;
    }
    .modal-insert input, .modal-insert select{
        margin-bottom: 10px;
    }
    #frm-insert label{
        padding-left: 10px;
        padding-right: 20px;
    }
</style>

<script>
    function detail($id){
        $("#table_ct tbody tr").remove();
        $.ajax({
            url: '<?php echo base_url() ?>admin/bills/detailBills',
            type: 'POST',
            dataType: 'json',
            data: {
                id_bill: $id
            }
        })
        .done(function(data){
            for (var i = 0; i < data.length; i++) {
                  $("#table_ct tbody").append("<tr><td>" +data[i].id_product + "</td><td>" +data[i].name + "</td><td>" +data[i].quantum + "</td><td>" +formatCurrency(data[i].money) + " đ</td></tr>");
            }
        })   
    }
    function formatCurrency(number){
            var n = number.split('').reverse().join("");
            var n2 = n.replace(/\d\d\d(?!$)/g, "$&,");    
            return  n2.split('').reverse().join('');
    }
</script>