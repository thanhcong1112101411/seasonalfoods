<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class bills extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');	
		$this->load->model('M_data');
		$this->load->library('session');
	}

	public function index()
	{	
        $query = "SELECT `id_bills`, `cusName`, `phone`, `address`, `total`, `status`, 
        create_at FROM bills, `customers` WHERE `bills`.`id_customer` = `customers`.`id_customer`";
        $data["bills"] = $this->M_data->load_query($query);
        $display["body"] = $this->load->view("admin/pages_admin/bills",$data,TRUE);
		$this->load->view("admin/home_admin/masterAdmin", $display);
	}

	public function detailBills(){
		$id_bill = $_POST['id_bill'];
		$query = "SELECT id_product, `name`, quantum, 
		detailbills.price FROM detailbills, 
		products WHERE detailbills.`id_product` = products.`id` AND id_bill = ".$id_bill;
		echo json_encode($this->M_data->load_query($query));
	}

}
?>