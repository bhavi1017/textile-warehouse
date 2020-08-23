<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buyer extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("HomeM","hm");	
		$this->load->model("BuyerM","bm");	
		// $this->load->model("ProductM","pm");
		$this->load->model("profileM","pm1");		
	}

	public function index()
	{
		$cinfo=$this->hm->selectallcat();
		$company_result=$this->bm->selectallcompanies();		
		$temp=array(
			"cat"=>$cinfo,
			"companies"=>$company_result
		);
		//print_r($company_result);
		$this->load->view("buyer",$temp);
	}

	public function loadcomapnies($cid)
	{		
				
		redirect("Companyinfo/index/$cid");
	}
}
?>