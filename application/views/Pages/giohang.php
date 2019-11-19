
<div class="banner">
    <img width="100%" src="<?php echo base_url() ?>public/images/banner/banner-cart.png"/>
    <div class="banner-content container banner-cart">
        <div>
            <h1>Giỏ Hàng</h1>
            <p>Your company will look astonishing. Attract more visitors, and win more business with Front template.</p>
        </div>
        
    </div>
</div>

<style>
    .banner-cart{
        padding-top: 20%;
    }
</style>
<div class="cart mt-5">
    <div class="container">
        <table class="table table-bordered text-center" style="box-shadow: 3px 3px 10px gray">
            <tr style="background-color: #3b9f5e; color: #fff">
                <th colspan="2">Sản Phẩm</th>
                <th>Giá</th>
                <th>Giảm Giá</th>
                <th>Số Lượng</th>
                <th>ĐVT</th>
                <th>Thành Tiền</th>
                <th></th>
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
                <td><input type="number" min="1" id="number" value="<?php echo $item['number']?>" onchange="change(<?php echo $item['id'] ?>,this.value)" /></td>
                <td><?php echo $item['unitName']?></td>
                <td><span id="thanhtien"><?php echo number_format($thanhtien) ?></span> đ</td>
                <td>
                    <button title="xóa sản phẩm" onclick="remove(<?php echo $item['id'] ?>)"><i class="fas fa-trash-alt"></i></button>
                </td>
                
            </tr>
            <?php }} else{ ?>
                
            <?php } ?>
            
        </table>
    </div>
</div>
<div class="payment">
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-8">
                <div class="payment-content">
                    <strong>Tổng Tiền: </strong>
                    <span id="tongtien"><?php echo ($giohang !=null)? number_format($tongtien): "0" ?></span> đ
                    <a href="<?php echo base_url()?>Handling/dathang">Tiến Hành Đặt Hàng</a>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .cart button{
        background-color: #fff;
        border: 0;
        color: red;
        cursor: pointer;
    }
    .payment .payment-content{
        height: 200px;
        padding: 20px;
        box-shadow: 3px 3px 10px gray;
        font-size: 18px;
    }
    .payment-content a{
        display: block;
        padding: 10px 20px;
        text-align: center;
        margin-top: 80px;
        text-decoration: none;
        background-color: #ff424e;
        color: #ffffff;
        font-size: 18px;
    }
</style>


<script>
    $(function(){
        $("header").addClass("header-fix");
    });
    
</script>
<script>
    function remove($id){
        $.ajax({
            url: '<?php echo base_url() ?>Handling/remove',
			type: 'POST',
			dataType: 'json',
			data: { number: $id},
        })
        .done(function(data){
            $('#tongtien').text(data.thanhtien);
            $('#id'+$id).remove();
            $('#numbercart sub').text(data.number);
        });
        
    }
    function change($id, number){
        if(number<1){
            number = 1;
            $('#id'+$id+" #number").val(number);
        }
        $.ajax({
            url: '<?php echo base_url() ?>Handling/changeNumber',
			type: 'POST',
			dataType: 'json',
			data: {number: number, id : $id},
        })
        .done(function(data){
            var t = data;
            $('#id'+$id+" #thanhtien").text(formatCurrency(t.thanhtien));
            $("#tongtien").text(formatCurrency(t.tongtien));
        });
      }
    
    
    function formatCurrency(number){
        var n = number.toString();
        n = n.split('').reverse().join("");
        var n2 = n.replace(/\d\d\d(?!$)/g, "$&,");    
        return  n2.split('').reverse().join('');
    }
</script>