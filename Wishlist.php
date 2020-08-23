<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wishlist extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model("WishlistM","wm");
		$this->load->model("SearchM","sm");
	}

	public function index()
	{
		$uid=$_SESSION['uid'];
		$inq=$this->wm->fetchunseenInquires();
		$f=$this->wm->fetchfromwishlistbyuserid($uid);
		//$uinfo=$this->wm->fetchUser($uid);
		$pinfo=$this->wm->fetchproductbasedonwishlist($uid);
		$product_id=$this->wm->fetchproductbycompanyid($uid);
		$data=array(
			"cnt"=>$this->wm->fetchcompanyfromuserid_cnt($uid),
			"inq_cnt"=>$inq,
			"fav"=>$f,
			"products"=>$pinfo,
			"pid"=>$product_id,
			//"user"=>$uinfo
		);
		$this->load->view("wishlist",$data);
	}

	public function remove_product_from_wishlist($pid)
	{
		$uid=$_SESSION['uid'];
		$winfo=$this->sm->fetchfromwishlist($uid,$pid);
		$wid=$winfo['wishlistid'];
		$this->sm->deletefromwishlist($wid);
		redirect("Wishlist/index");
	}

	
}
?>