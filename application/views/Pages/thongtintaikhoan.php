
<div class="container customerinf">
    <div>
        <div class="mb-5">
            <h2 class="text-center">Thông Tin Khách Hàng</h2>
        </div>
        <div>
            <input id="name" type="text" value="<?php echo $customer[0]["cusName"] ?>" class="form-control" placeholder="Họ Tên">
        </div>
        <div>
            <input id="email" type="email" value="<?php echo $customer[0]["email"] ?>" class="form-control" placeholder="Email">
        </div>
        <div>
            <input id="phonenumber" maxlength="10" type="tel" value="<?php echo $customer[0]["phonenumber"] ?>" class="form-control" placeholder="Số Điện Thoại">
        </div>
        <div>
            <label>Tỉnh/Thành Phố</label>
            <select id="cityData" class="form-control"></select>
        </div>
        <div>
            <label>Quận/Huyện</label>
            <select id="districtData" class="form-control"></select>
        </div>
        <div>
            <label>Xã/Phường</label>
            <select id="wardData" class="form-control"></select>
        </div>
        <div>
            <label>Địa Chỉ</label>
            <textarea id="address" class="form-control"><?php echo $customer[0]["address"] ?></textarea>
        </div>
        <div>
            <button onclick="update()">Cập Nhật</button>
        </div>
    </div>
</div>
<style>
    .customerinf{
        font-size: 17px;
        display: flex;
        flex-wrap: wrap;
        margin-top: 50px;
    }
    .customerinf>div{
        width: 50%;
        padding: 10px;
        border: 1px solid #eee;
        box-shadow: 5px 5px 5px #eee;
        padding: 20px;
        margin: auto;
        padding-bottom: 40px;
    }
    .customerinf>div>div{
        margin-top: 20px;

    }
    .customerinf button{
        border: 0;
        color: #fff;
        background-color: green;
        cursor: pointer;
        padding: 10px 25px;
        margin: auto;
        display: block;
        font-size: 18px;
        font-weight: 500;
    }
</style>
<script>
    $(function(){
        // $("header").addClass("header-fix");
        var city = <?php echo $customer[0]["city"] ?>;
        var district = <?php echo $customer[0]["district"] ?>;
        var ward = <?php echo $customer[0]["ward"] ?>;
        // load dữ liệu city
        $.ajax({
            url: '<?php echo base_url() ?>Handling/getLink',
            type: 'POST',
            dataType: 'json',
            data: { link: "https://thongtindoanhnghiep.co/api/city"},
        })
        .done(function(data){
            for (var item of data.LtsItem) {
                if(item.ID == city){
                    $('#cityData').append('<option selected value=' + item.ID + '>' + item.Title + '</option>');
                }else{
                    $('#cityData').append('<option value=' + item.ID + '>' + item.Title + '</option>');
                } 
            }
        });
        // load dữ liệu quận huyện
        $.ajax({
            url: '<?php echo base_url() ?>Handling/getLink',
            type: 'POST',
            dataType: 'json',
            data: { link: "https://thongtindoanhnghiep.co/api/city/"+city+"/district"},
        })
        .done(function(data){
            for (var item of data) {
                if(item.ID == district){
                    $('#districtData').append('<option selected value=' + item.ID + '>' + item.Title + '</option>');
                }else{
                    $('#districtData').append('<option value=' + item.ID + '>' + item.Title + '</option>');
                } 
            }
        });
        // load dữ liệu xã phường
        $.ajax({
            url: '<?php echo base_url() ?>Handling/getLink',
            type: 'POST',
            dataType: 'json',
            data: { link: "https://thongtindoanhnghiep.co/api/district/"+district+"/ward"},
        })
        .done(function(data){
            for (var item of data) {
                if(item.ID == ward){
                    $('#wardData').append('<option selected value=' + item.ID + '>' + item.Title + '</option>');
                }else{
                    $('#wardData').append('<option value=' + item.ID + '>' + item.Title + '</option>');
                } 
            }
        });
        
        // $('#cityData').val(city);
        
    });
    $("#cityData").on("change",function(){
        var city = $(this).val();
        $.ajax({
            url: '<?php echo base_url() ?>Handling/getLink',
            type: 'POST',
            dataType: 'json',
            data: { link: "https://thongtindoanhnghiep.co/api/city/"+city+"/district"},
        })
        .done(function(data){
            $('#districtData').children().remove();
            $('#wardData').children().remove();
            var district = data[0].ID;
            // load dữ liệu xã phường
            $.ajax({
                url: '<?php echo base_url() ?>Handling/getLink',
                type: 'POST',
                dataType: 'json',
                data: { link: "https://thongtindoanhnghiep.co/api/district/"+district+"/ward"},
            })
            .done(function(data){
                for (var item of data) {
                        $('#wardData').append('<option value=' + item.ID + '>' + item.Title + '</option>');
                }
            });


            for (var item of data) {
                 $('#districtData').append('<option value=' + item.ID + '>' + item.Title + '</option>');
            }
        });
        

    });
    $("#districtData").on("change",function(){
        var district = $(this).val();
        
        // load dữ liệu xã phường
        $.ajax({
            url: '<?php echo base_url() ?>Handling/getLink',
            type: 'POST',
            dataType: 'json',
            data: { link: "https://thongtindoanhnghiep.co/api/district/"+district+"/ward"},
        })
        .done(function(data){
            $('#wardData').children().remove();
            for (var item of data) {
                $('#wardData').append('<option value=' + item.ID + '>' + item.Title + '</option>'); 
            }
        });
    });
    function update(){
        var form = createFormData();
        $.ajax({
            url: '<?php echo base_url()?>Handling/updateCustomerInf',
            dataType: 'html',
            cache: false,
            contentType: false,
            processData: false,
            data: form,
            type: 'post',
            success: function (data) {
                if(document.referrer == "<?php echo base_url() ?>Handling/dathang"){
                     window.location = "<?php echo base_url() ?>Handling/dathang";
                }else{
                    alert("Cập Nhật Thành Công");
                }
            }
        });
    }
    function createFormData(){
        var form = new FormData();
        var name = $("#name").val();
        var email = $("#email").val();
        var phonenumber = $("#phonenumber").val();
        var idCity = $("#cityData").val();
        var idDistrict = $("#districtData").val();
        var idWard = $("#wardData").val();
        var address = $("#address").val();

        if(name.trim() == "" || email.trim()=="" || phonenumber.trim()=="" || address.trim()==""){
            alert("Cần Nhập Đầy Đủ Thông Tin");
            exit();
        }

        form.append("name",name);
        form.append("email",email);
        form.append("phonenumber",phonenumber);
        form.append("idCity",idCity);
        form.append("idDistrict",idDistrict);
        form.append("idWard",idWard);
        form.append("address",address);

        return form;
    }
</script>