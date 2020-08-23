<?php

class Companyinfo extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();
		$this->load->model("profileM","pm");
		$this->load->model("inquiryM","im");
	}
	public function index($id)
	{
		$_SESSION['compid']=$id;
		//echo $_SESSION['compid'];
		$product_result=$this->im->productsByCompanyId($id);
		$inquiry_result=$this->im->fetchAllInquiry($id);
		$company_result=$this->pm->userdataById($id);
		$contact_result=$this->pm->fetchcontact($id);
		$email_result=$this->pm->fetchcompanyemail($id);
		$website_result=$this->pm->fetchwebsite($id);
		$info=array(
			"pinfo"=>$product_result,
			"companyinfo"=>$company_result,
			"contactinfo"=>$contact_result,
			"websiteinfo"=>$website_result,
			"emailinfo"=>$email_result,
			"iinfo"=>$inquiry_result
		);
		$this->load->view("companymoreinfo",$info);
	}
	public function productinfo($id)
	{
		$product_result=$this->pm->productById($id);
		foreach ($product_result as $p) 
		{
	?>			
			<div class="row" style="background-color: skyblue">				
				<div class="pbox col-lg-4" style="margin-left: 170px; background-color: white;">				
					<h2><?php echo $p['title'] ?></h2>
					<h6>Product-ID : <?php echo $p['productid'] ?></h6>
					<br>
					<h3>PrIcInG</h3>
					<h6>Min Price : <?php echo $p['min_price'] ?></h6>
					<h6>Max Price : <?php echo $p['max_price'] ?></h6>
					<br>
					<h3>AbOuT PrOdUcTs</h3>
					<h6>
						Status :
						<?php 
						if($p['status']==1){
							echo "Available";
						}
						else
						{
							echo "Out Of Stock";
						}
						?>
					</h6>
					<h6>Description : <?php echo $p['description'] ?></h6>
					<h6>Min_Order : <?php echo $p['min_order'] ?></h6>					
				</div>
			</div>
	<?php	
		}
	}

	public function more_image($id)
	{
		$result=$this->pm->fetch_image($id);
		$data=array(
			'img'=>$result
		);
		$this->load->view("more_img",$data);
	}
}
?>