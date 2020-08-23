<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("profileM","pm");
		$this->load->model("HomeM","hm");
		$this->load->model("SellerM","sm");
	}
	
	public function seller_page()
	{
		$id=0;
		$uid=$_SESSION['uid'];
		$uname=$_SESSION['uname'];		
		$pids=$this->sm->selelctallproductsbyuserid($uid);
		$incnts=$this->sm->selelctallinquiressbycompanyid($uid);
		$result=$this->hm->fetchUserRegisterData($uname);
		$id=$result['userid'];
		$answer=$this->pm->fetchCompaniesByUserId($id);
		$data=array(
			"users"=>$result,
			"companies"=>$answer,
			"pid"=>$pids,
			"incnt"=>$incnts
		);		
		$this->load->view("seller",$data);
	}
}
?>