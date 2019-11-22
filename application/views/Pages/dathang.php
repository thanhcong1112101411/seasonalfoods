
<div class="container pt-5">
    <h1>Thông Tin Giao Hàng</h1>
    <hr/>
</div>
<div class="container customerInf">
    <p>Họ Tên: <span><?php echo $customer[0]["cusName"] ?></span></p>
    <p>Email: <span><?php echo $customer[0]["email"] ?></span></p>
    <p>Số Điện Thoại: <span><?php echo $customer[0]["phonenumber"] ?></span></p>
    <p>Địa Chỉ: <span id="address"><?php echo $customer[0]["address"] ?></span> </p>
    
    <a href="<?php echo base_url() ?>Handling/thongtintaikhoan">Cập Nhật Thông Tin</a>
</div>
<style>
    .customerInf p{
        font-size: 18px;
    }
    .customerInf a{
        background-color: #3b9f5e;
        color: #fff;
        border: 0;
        padding: 10px 15px;
        font-size: 18px;
        cursor: pointer;
        margin-top: 20px;
        display: inline-block;
        text-decoration: none;
        font-weight: 500;
    }
</style>
<div class="container pt-5">
    <h1>Danh Sách Sản Phẩm</h1>
    <hr/>
</div>
<div class="container product-inf">
    <table class="table table-bordered text-center" style="box-shadow: 3px 3px 10px gray">
            <tr style="background-color: #3b9f5e; color: #fff">
                <th colspan="2">Sản Phẩm</th>
                <th>Giá</th>
                <th>Giảm Giá</th>
                <th>Số Lượng</th>
                <th>ĐVT</th>
                <th>Thành Tiền</th>
            </tr>
            <?php if($giohang !=null){
                $tongtien = 0;
                foreach($giohang as $item){
                    $thanhtien = 0;
                    if($item['quantumDiscount'] != null){
                        $thanhtien = ($item['price'] * (1-$item['quantumDiscount']/100))*$item['number'];
                    }else{
                        $thanhtien = $item['price'] * $item['number'];
                    }
                    
                    $tongtien += $thanhtien;
            ?>
            <tr id="id<?php echo $item['id'] ?>">
                <td><img width="150px" src="<?php echo base_url() ?>public/images/products/<?php echo $item['image']?>" /></td>
                <td><?php echo $item['name']?></td>
                <td><span id="price"><?php echo number_format($item['price'])?></span> đ</td>
                <td><?php echo ($item['quantumDiscount'] != null) ? "-".$item['quantumDiscount'] : 0 ?>%</td>
                <td><?php echo $item['number']?></td>
                <td><?php echo $item['unitName']?></td>
                <td><span id="thanhtien"><?php echo number_format($thanhtien) ?></span> đ</td>
            </tr>
            <?php }} else{ ?>
                
            <?php } ?>
            
        </table>
</div>
<div class="payment">
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-8">
                <div class="payment-content">
                    <strong>Tổng Tiền: </strong>
                    <span id="tongtien"><?php echo ($giohang !=null)? number_format($tongtien): "0" ?> đ</span>
                    <button onclick="thanhtoan()">Thanh Toán</button>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .payment .payment-content{
        height: 200px;
        padding: 20px;
        box-shadow: 3px 3px 10px gray;
        font-size: 18px;
    }
    .payment-content button{
        display: block;
        padding: 10px 20px;
        text-align: center;
        margin-top: 80px;
        text-decoration: none;
        background-color: #ff424e;
        color: #ffffff;
        font-size: 18px;
        border: 0;
        width: 100%;
        cursor: pointer;
    }
    .payment-content span{
        color: red;
        font-weight: 500;
    }
</style>

<script>
    $(function(){
        // $("header").addClass("header-fix");

        // lấy tên phường, xã

        $.get( "<?php echo base_url()?>Handling/getAddress", function( data ) {
            var obj = jQuery.parseJSON(data);
            $("#address").text( $("#address").text() +", "+ jQuery.parseJSON(obj.ward).Title +", "+ jQuery.parseJSON(obj.district).Title +", "+ jQuery.parseJSON(obj.city).Title);
            
        });


    });
    function thanhtoan(){
        $.get( "<?php echo base_url()?>Handling/thanhtoan", function( data ) {
            
        });
        window.location = "<?php echo base_url() ?>Handling/danhsachdonhang";
    }

</script>