<div class="banner">
    <img width="100%" src="<?php echo base_url() ?>public/images/banner/white.png"/>
    <div class="banner-content container">
        <div>
            <h1><?php echo $product[0]['name'] ?></h1>
            <p>Your company will look astonishing. Attract more visitors, and win more business with Front template.</p>
        </div>
        
    </div>
    <div class="circle-main">
        <img width="100%" src="<?php echo base_url() ?>public/images/bannerDetail/girl-3_02.jpg"/>
        <div class="circle-content text-center">
            <h1 class="h3 mb-4">Ain't Got Far To Go Tour Playlist</h1>
            <p>Joss-embarks on a tour of the US and Europe this fall, where she'll be listening these recent tracks </p>
            <input type="submit" value="VIEW PLAYLIST"/>
        </div>
        <div class="circle-sp circle-1 fadeInDown animated">
            <img width="100%" src="<?php echo base_url() ?>public/images/bannerDetail/girl-2_02.jpg"/>
        </div>
        <div class="circle-sp circle-2 fadeInRight animated">
            <img width="100%" src="<?php echo base_url() ?>public/images/bannerDetail/girl-1_03.jpg"/>
        </div>
        <div class="circle-sp circle-3 fadeInUp animated">
            <img width="100%" src="<?php echo base_url() ?>public/images/bannerDetail/girl-4_02.jpg"/>
        </div>
        <div class="circle-sp circle-4 fadeInUp animated">
            <img width="100%" src="<?php echo base_url() ?>public/images/bannerDetail/girl-5_02.jpg"/>
        </div>
        <div class="circle-sp circle-5 fadeInLeft animated">
            <img width="100%" src="<?php echo base_url() ?>public/images/bannerDetail/girl-6_02.jpg"/>
        </div>
    </div>
</div>
<style>
    .banner{
    position: relative;
}
.banner-content{
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    padding-top: 80px;
}
.banner-content h1{
    color: #3b9f5e;
    font-weight: 900;
    font-size: 80px;
    text-shadow: 3px 3px 10px #b1e9c5;
}
.banner-content>div{
    width: 45%;
}
.banner-content p{
    color: #77838f;
    font-size: 18px;
    margin-top: 30px;
}
    .banner{
        overflow: hidden;
    }
    .banner-content{
        padding-top: 150px;
    }
    .banner-content p{
        color: #ffffff;
    }
    .circle-main{
        width: 350px;
        height: 350px;
        border-radius: 50%;
        position: absolute;
        right: 7%;
        top: 20%;
        box-shadow: 3px 3px 10px gray;
        z-index: 100;
    }
    .circle-main img{
        border-radius: 50%;
        opacity: 1;
        border: 4px solid #fff;
        box-sizing: border-box;
    }
    .circle-main>div{
        position: absolute;
        border-radius: 50%;
    }
    .circle-content{
        color: #fff;
        padding: 30px;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        
    }
    .circle-content input{
        width: 50%;
        border-radius: 20px;
        padding: 10px;
        color: black;
        border: 0;
        font-size: 16px;
        font-weight: 500;
        background-color: #fff;
        margin-top: 20px;
    }
    .circle-sp{
        z-index: -1;
    }
    .circle-sp img:hover{
        transform: translateY(-5px);
        transition: all 0.5s;
    }
    .circle-1{
        width: 200px;
        height: 200px;
        top: -30%;
        left: -15%;
    }
    .circle-2{
        width: 230px;
        height: 230px;
        top: -20%;
        right: -35%;
    }
    .circle-3{
        width: 100px;
        height: 100px;
        bottom: 5%;
        right: -15%;
    }
    .circle-4{
        width: 150px;
        height: 150px;
        bottom: -25%;
        left: -5%;
    }
    .circle-5{
        width: 180px;
        height: 180px;
        top: 30%;
        left: -45%;
    }
</style>
<div class="container detailmain">
    <div class="row">
        <div class="col-md-5">
            <img width="100%" src="<?php echo base_url()?>public/images/products/<?php echo $product[0]['image'] ?>"/>
        </div>
        <div class="col-md-6 offset-md-1">
            
            <h1><?php echo $product[0]['name'] ?></h1>
            <p><?php echo $product[0]['description']?></p>
            <?php if($product[0]['quantumDiscount'] != null):
                    $sellprice = $product[0]['price'] * (1 - $product[0]['quantumDiscount']/100);
                ?>
                    <p>Giảm Giá: <span class='price'>-<?php echo $product[0]['quantumDiscount'] ?>%</span></p>
                <?php endif;  ?>
            <p>
                Giá: 
                <?php if($product[0]['quantumDiscount'] != null):
                    $sellprice = $product[0]['price'] * (1 - $product[0]['quantumDiscount']/100);
                ?>
                    <span class="price"><?php echo  number_format($sellprice)?> đ</span>/<?php echo $product[0]['unitName'] ?>
                    <span class="linethrought"><?php echo number_format($product[0]['price']) ?> đ</span>
                <?php endif;  ?>
                
                
                
                <?php if($product[0]['rrp'] != 0 && $product[0]['quantumDiscount'] == null):
                ?>
                    <span class="price"><?php echo number_format($product[0]['price']) ?> đ</span>/<?php echo $product[0]['unitName'] ?>
                    <span class="linethrought"><?php echo  number_format($product[0]['rrp'])?> đ</span>
                    
                <?php endif;  ?>
                
                
            </p>
            
            <button onclick="order(<?php echo $product[0]['id'] ?>)">Thêm Vào Giỏ Hàng</button>
            
        </div>
    </div>
</div>
<style>
    .detailmain h1{
        color: green;
        font-weight: bold;
        font-size: 45px;
    }
    .detailmain button{
        display: inline-block;
        margin-top: 20px;
        font-size: 19px;
        padding: 10px 17px;
        background-color: red;
        color: #fff;
        border-radius: 3px;
        border: 0;
        cursor: pointer;
    }
    .detailmain button:hover{
        transform: translateY(-5px);
        transition: all 0.5s;
    }
    .detailmain p{
        color: gray;
        font-weight: bold;
        font-size: 18px;
    }
    .price{
        color: red;
    }
    .linethrought{
        text-decoration:line-through;
        margin-left: 10px;
    }
</style>
<script>
    $(function(){
        $("header").addClass("header-fix");
    });
    function order($id){
        $.ajax({
            url: '<?php echo base_url() ?>Handling/datthem',
            type: 'POST',
            dataType: 'html',
            data: {
                id:$id,
            }
        })
        .done(function(data){
            $('#numbercart sub').text(data);
            alert("Đã Thêm Sản Phẩm Vào Giỏ Hàng");
                    
        })
    }
</script>