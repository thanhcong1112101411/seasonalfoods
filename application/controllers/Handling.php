<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Handling extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');	
        $this->load->model('M_data');
		$this->load->library('session');
        
	}
    
	public function index()
	{

        $querySell = "SELECT * from products LEFT JOIN productstotal on productstotal.id_product = products.id LEFT JOIN discountcodedetail ON products.id = discountcodedetail.id_product LEFT JOIN discountcodeapply on discountcodedetail.id_code = discountcodeapply.id_discountcode where hidden=0 order by quantumTotal DESC limit 3";
        $data["sellProducts"] = $this->M_data->load_query($querySell);
        $queryNew = "SELECT * from products LEFT JOIN discountcodedetail ON products.id = discountcodedetail.id_product LEFT JOIN discountcodeapply on discountcodedetail.id_code = discountcodeapply.id_discountcode where hidden=0 order by create_at desc limit 8";
        $data["newProducts"] = $this->M_data->load_query($queryNew);
        $display["header"] = $this->load->view("Home/header",NULL,TRUE);
        $display["banner"] = $this->load->view("Home/banner",NULL,TRUE);
        $display["footer"] = $this->load->view("Home/footer",NULL,TRUE);
        $display["body"] = $this->load->view("Pages/trangchu",$data,TRUE);
		$this->load->view("Home/master", $display);
	}
    public function sanpham()
	{
        $queryPor = "select * from portfolio";
        $data["portfolios"] = $this->M_data->load_query($queryPor);
        $queryPro = "select * from products where hidden = 0";
        $products = $this->M_data->load_query($queryPro);
        $data["countProduct"] = count($products);
        
        $signal["sanpham"] = "active";
        $display["header"] = $this->load->view("Home/header",$signal,TRUE);
        $display["footer"] = $this->load->view("Home/footer",NULL,TRUE);
        $display["body"] = $this->load->view("Pages/sanpham",$data,TRUE);
		$this->load->view("Home/master", $display);
	}
    public function lienhe()
	{
        $signal["lienhe"] = "active";
        $display["header"] = $this->load->view("Home/header",$signal,TRUE);
        $display["footer"] = $this->load->view("Home/footer",NULL,TRUE);
        $display["body"] = $this->load->view("Pages/lienhe",NULL,TRUE);
		$this->load->view("Home/master", $display);
	}
    public function thongtintaikhoan(){
        $id = $this->session->userdata("user")["id"];
        $query = "select * from customers where id_customer = '".$id."'";
        $data["customer"] = $this->M_data->load_query($query);
        $display["header"] = $this->load->view("Home/header",NULL,TRUE);
         $display["footer"] = $this->load->view("Home/footer",NULL,TRUE);
        $display["body"] = $this->load->view("Pages/thongtintaikhoan",$data,TRUE);
		$this->load->view("Home/master", $display);
    }
    public function danhsachdonhang(){
        $id = $this->session->userdata("user")["id"];
        $query = "select * from bills where id_customer = '".$id."' order by create_at";
        $data["bills"] = $this->M_data->load_query($query);
        $display["header"] = $this->load->view("Home/header",NULL,TRUE);
        $display["footer"] = $this->load->view("Home/footer",NULL,TRUE);
        $display["body"] = $this->load->view("Pages/danhsachdonhang",$data,TRUE);
		$this->load->view("Home/master", $display);
    }
    
    public function chitietsanpham($id=""){
        $signal["chitietsanpham"] = "active";
        $query = "SELECT * from (SELECT * from products WHERE products.id = '".$id."') as a LEFT JOIN discountcodedetail on a.id = discountcodedetail.id_product LEFT JOIN discountcodeapply on discountcodedetail.id_code = discountcodeapply.id_discountcode LEFT JOIN unit on a.id_unit = unit.id_units";
    
        $data["product"] = $this->M_data->load_query($query);
        $display["header"] = $this->load->view("Home/header",$signal,TRUE);
        $display["footer"] = $this->load->view("Home/footer",NULL,TRUE);
        $display["body"] = $this->load->view("Pages/chitietsanpham",$data,TRUE);
		$this->load->view("Home/master", $display);
    }
    public function getdetailbill(){
        $idbill = $this->input->post("idbill");
        $query = "select products.image, products.name, detailbills.* from detailbills, products WHERE detailbills.id_product = products.id and detailbills.id_bill = '".$idbill."'";
        $detailbilllist = $this->M_data->load_query($query);
        echo json_encode($detailbilllist);
    }
    public function filter(){
        $quantumProduct = 9;
        $page = (int)$this->input->post("page");
        $limit1 = ($page-1)* $quantumProduct;
        $limit2 = $quantumProduct;
        
        $portfolios = $this->input->post("portfolios");
        $price = $this->input->post("price");
        $search = $this->input->post("search");
        
        $portfolios = json_decode($portfolios);
    
        $query = "SELECT * from products LEFT JOIN discountcodedetail ON products.id = discountcodedetail.id_product LEFT JOIN discountcodeapply on discountcodedetail.id_code = discountcodeapply.id_discountcode LEFT JOIN portfolio ON products.id_por = portfolio.id_portfolio LEFT JOIN brand ON products.id_brand = brand.id_brands where hidden=0 and name like '%".$search."%'";
        $price = trim($price);
        
        if($portfolios != null){
                $query .= " and (";
                for($i=0; $i<count($portfolios); $i++){
                    if($i == count($portfolios) - 1){
                        $query .= "id_por = ".$portfolios[$i].")";
                    }
                    else{
                        $query .= "id_por = ".$portfolios[$i]." or ";
                    }
                }
            
            }
        
        
        if($price != "0"){
            $query.= " order by price";
            if($price == "1"){
                $query.=" desc";
            }
            if($price == "2"){
                $query.=" asc";
            }
        }
        $products = $this->M_data->load_query($query);
        $data["quantum"] = count($products);
        $query .= " limit ".$limit1.",".$limit2;
        $data["limit"] = $this->M_data->load_query($query);
        echo json_encode($data);
    }
    public function giohang()
	{
//        $this->session->unset_userdata('giohang');
        $data['giohang'] = $this->session->userdata("giohang");
        $display["header"] = $this->load->view("Home/header",NULL,TRUE);
        $display["footer"] = $this->load->view("Home/footer",NULL,TRUE);
        $display["body"] = $this->load->view("Pages/giohang",$data,TRUE);
		$this->load->view("Home/master", $display);
	}
    public function datthem()
	{
        
        $id = $this->input->post('id');
        $query = "SELECT * from (SELECT * from products WHERE products.id = '".$id."') as a LEFT JOIN discountcodedetail on a.id = discountcodedetail.id_product LEFT JOIN discountcodeapply on discountcodedetail.id_code = discountcodeapply.id_discountcode LEFT JOIN unit on a.id_unit = unit.id_units";
        $sanpham = $this->M_data->load_query($query);
        
		if($this->session->has_userdata('giohang'))
		{
			$arr_old = $this->session->userdata("giohang");
            // kiểm tra trùng
            for($i=0; $i<count($arr_old); $i++){
                if($arr_old[$i]['id'] == $id){
                    $arr_old[$i]['number']+=1;
                    $this->session->set_userdata("giohang",$arr_old);
                    redirect(base_url('handling/giohang'));
                }
            }
            
            
			$arr_new['id'] = $id;
			$arr_new['name'] = $sanpham[0]['name'];
			$arr_new['price'] = $sanpham[0]['price'];
            $arr_new['quantumDiscount'] = $sanpham[0]['quantumDiscount'];
			$arr_new['number'] = 1;
            $arr_new['image'] = $sanpham[0]['image'];
            $arr_new['unitName'] = $sanpham[0]['unitName'];
			array_push($arr_old, $arr_new);
			$this->session->set_userdata("giohang",$arr_old);
		}
		else
		{
			$arr_new[0]['id'] = $id;
			$arr_new[0]['name'] = $sanpham[0]['name'];
			$arr_new[0]['price'] = $sanpham[0]['price'];
            $arr_new[0]['quantumDiscount'] = $sanpham[0]['quantumDiscount'];
			$arr_new[0]['number'] = 1;
            $arr_new[0]['image'] = $sanpham[0]['image'];
            $arr_new[0]['unitName'] = $sanpham[0]['unitName'];
	
			$this->session->set_userdata("giohang",$arr_new);
		}
        
		
	   echo count($this->session->userdata("giohang"));
        
        
	}
    public function changeNumber(){
    
        $id = $this->input->post('id');
        $number = $this->input->post('number');
        $arr_old = $this->session->userdata("giohang");
        
        $thanhtien = 0;
        for($i=0; $i<count($arr_old); $i++){
            if($arr_old[$i]['id'] == $id){
                $arr_old[$i]['number'] = $number;
                
                if($arr_old[$i]["quantumDiscount"] != null){
                    $thanhtien = ($arr_old[$i]['price'] * (1-$arr_old[$i]['quantumDiscount']/100))* $number;
                }else{
                    $thanhtien = $arr_old[$i]['price'] * $number;
                }
            }
        }
        
        $this->session->set_userdata("giohang",$arr_old);
        $tongtien = 0;
        for($i=0; $i<count($arr_old); $i++){
            if($arr_old[$i]["quantumDiscount"] != null){
                $tongtien += ($arr_old[$i]['price'] * (1-$arr_old[$i]['quantumDiscount']/100))* $arr_old[$i]['number'];
            }else{
                $tongtien += $arr_old[$i]['price'] * $arr_old[$i]['number'];
            }
            
        }
        $data["thanhtien"] = $thanhtien;
        $data["tongtien"] = $tongtien;
        echo json_encode($data);
    }
    public function remove(){
        $id = $this->input->post('number');
        $arr_old = $this->session->userdata("giohang");
        for($i = 0; $i<count($arr_old); $i++){
            if($arr_old[$i]['id'] == $id)
                unset($arr_old[$i]);
        }
        $arr_old = array_values($arr_old);
        $this->session->set_userdata("giohang",$arr_old);
        
        $result["thanhtien"] = 0;
        for($i=0; $i<count($arr_old); $i++){
            if($arr_old[$i]["quantumDiscount"] != null){
                $result["thanhtien"] += ($arr_old[$i]['price'] * (1-$arr_old[$i]['quantumDiscount']/100))* $arr_old[$i]['number'];
            }else{
                $result["thanhtien"] += $arr_old[$i]['price'] * $arr_old[$i]['number'];
            }
        }
        $result["number"] = count($arr_old);
        echo json_encode($result);
    }
    public function login(){
        $username = $this->input->post("username");
        $pass = $this->input->post("password");
        
        $query = "select * from accountcustomers where username='".$username."' and password = '".$pass."'";
        $data = $this->M_data->load_query($query);
        if(count($data) > 0){
            $arr_user["id"] = $data[0]["id_customer"];
            $arr_user['username'] = $data[0]['username'];
            $arr_user['password'] = $data[0]['password'];
	
			$this->session->set_userdata("user",$arr_user);
            redirect('../');
        }
        else{
            echo "<script>alert('Tài Khoản không tồn tại'); window.location.href='../'</script>";
        }
        
    }
    public function logout(){
        $this->session->unset_userdata("user");
        redirect(base_url(''));
    }
    
    public function dathang(){
        
            $id = $this->session->userdata("user")["id"];
            $queryAddress = "select * from customers where id_customer = '".$id."'";
            $data["customer"] = $this->M_data->load_query($queryAddress);
        
        
        $display["header"] = $this->load->view("Home/header",$data,TRUE);
        $display["footer"] = $this->load->view("Home/footer",NULL,TRUE);
        $display["body"] = $this->load->view("Pages/dathang",NULL,TRUE);
		$this->load->view("Home/master", $display);
    }
   
}
