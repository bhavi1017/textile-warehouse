<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model("SearchM","sm");
		$this->load->model("profileM","pm1");
	}

	public function index()	
	{
		$sid=$this->input->post("cmbsubcat");		
		$cinfo=$this->sm->selectproductbysubcatid($sid);
		$data=array(
			"company"=>$cinfo,
			"subid"=>$sid
		);
		// echo $sid;
		// print_r($cinfo);
		$this->load->view("search",$data);
	}

	public function loadproductbysubcatid($sid)
	{
		$pinfo=$this->sm->selectproductbysubcatid($sid);
		$cnt=count($pinfo);		
		$data=array(
			"product"=>$pinfo,
			"cnt"=>$cnt,
			"subid"=>$sid
		);
		$this->load->view("searchproduct",$data);	
	}

	public function loadcompanybysubcatid($id)
	{		
		$cinfo=$this->sm->selectcompanybysubcatid($id);
		$data=array(
			"company"=>$cinfo,
			"subid"=>$id
		);
		$this->load->view("searchpage",$data);
	}

	public function productinfo($id)
	{
		$product_result=$this->pm1->productById($id);
		foreach ($product_result as $p) 
		{
	?>		<center><h2 style="margin-top: -50px; font-family: serif;">PRODUCT INFO</h2></center>
			<div class="row" style=" margin-left: 250px;">	
				<div>
					<img src="<?php echo base_url('resources/user/products/'.$p['pro_img']) ?>" style="height: 400px;width: 400px;" >
				</div>
				<div class="pbox col-lg-4" style= " margin-left: 20px; background-color: white; color: black;">					
					<h2><?php echo $p['title'] ?></h2>
					<h6>Product-ID : <?php echo $p['productid'] ?></h6>					
					<h3>PrIcInG</h3>
					<h6>Min Price : <?php echo $p['min_price'] ?></h6>
					<h6>Max Price : <?php echo $p['max_price'] ?></h6>					
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
					<h6 class="col-lg-12">Min_Order : <?php echo $p['min_order'] ?></h6>					
				</div>
			</div>
	<?php	
		}
	}

	public function loadAllCompanyByCity($subcat)
	{
		$result=$this->sm->selectproductbysubcatid($subcat);		
		if(!empty($result))
		{
		?>
			<div class="container">
				<div class="row">
		<?php		
			foreach ($result as $company) 
			{
		?>
					<div class="col-lg-4" style="margin-bottom: 20px;">
						<div class="placeinfos">
							<h3><a href="<?php echo base_url('index.php/Search/more_info/'.$company['companyid']).'/'.$subcat ?>" title="" target="_blank"><?php echo $company['companyname']; ?></a></h3>
							<span style="margin-bottom: 5px;"We>We Would Serve Our Best</span>
							<?php
							if($company['companyprofilepic']=="null")
							{
							?>
								<img src="<?php echo base_url('resources/user/company_images/download.png') ?>" style="height: 150px;width: 330px;background-attachment: fixed;">
							<?php
							}
							else
							{
							?>
								<img src="<?php echo base_url('resources/user/company_images/'.$company['companyprofilepic']) ?>" style="height: 150px;width: 330px;background-attachment: fixed;">
							<?php								
							}
							?>
							<ul class="listmetas" style="margin-left: -10px;">
								<li class="btn"><a href="<?php echo base_url('index.php/Search/more_info/'.$company['companyid']).'/'.$subcat ?>">Make Inquiry</a></li>
								&nbsp
								<li class="btn"><i class="flaticon-phone-call"></i><a href="">  Call Here</a></li>
								&nbsp
								<li class="btn"><a href="<?php echo base_url('index.php/Companyinfo/index/'.$company['companyid']) ?>" target="_blank">Company Info</a></li>
							</ul>
						</div>
						<div class="placedetails">
							<?php
							if(strpos($company['googlemapurl'],"https://www.google.com/")===0)
							{
							?>	
								<a href="<?php echo $company['googlemapurl'] ?>" target="_blank" class="pull-left" style="margin-top: 14px;color: black;"><i class="flaticon-pin"></i>
								Get Direction</a>		
							<?php	
							}
							else
							{
							?>
								<a href="<?php echo base_url('index.php/Home/error') ?>" target="_blank" class="pull-left" style="margin-top: 14px;color: black;"><i class="flaticon-pin"></i>
								Get Direction</a>
							<?php	
							}
							?>
							<span class="pull-right"><i class="flaticon-phone-call"></i>+<?php echo $company['contact']; ?></span>
						</div>
					</div>
		<?php	
			}
		?>
				
				</div>	
			</div>
		<?php				
		}
	}

	public function loadCompanyByCity($cid,$subcat)
	{
		$result=$this->sm->fetchCompanyByCity($cid,$subcat);
		if(!empty($result))
		{
		?>
			<div class="container" style="margin-bottom: 20px;">
				<div class="row">

		<?php		
			foreach ($result as $company) 
			{
		?>
					<div class="col-lg-4" style="margin-bottom: 20px;">
						<div class="placeinfos">
							<h3><a href="<?php echo base_url('index.php/Search/more_info/'.$company['companyid']).'/'.$subcat ?>" title="" target="_blank"><?php echo $company['companyname']; ?></a></h3>
							<span style="margin-bottom: 5px;"We>We Would Serve Our Best</span>
							<?php
							if($company['companyprofilepic']=="null")
							{
							?>
								<a href="<?php echo base_url('index.php/Search/more_info/'.$company['companyid']).'/'.$subcat ?>" title="" target="_blank"><img src="<?php echo base_url('resources/user/company_images/download.png') ?>" style="height: 150px;width: 330px;background-attachment: fixed;"></a>
							<?php
							}
							else
							{
							?>
								<a href="<?php echo base_url('index.php/Search/more_info/'.$company['companyid']).'/'.$subcat ?>" title="" target="_blank"><img src="<?php echo base_url('resources/user/company_images/'.$company['companyprofilepic']) ?>" style="height: 150px;width: 330px;background-attachment: fixed;"></a>
							<?php								
							}
							?>
							<ul class="listmetas" style="margin-left: 40px;">
								<li class="btn"><i class="flaticon-phone-call"></i><a href="">  Call Here</a></li>
								<li class="btn"><a href="<?php echo base_url('index.php/Companyinfo/index/'.$company['companyid']) ?>" target="_blank">Company Info</a></li>
							</ul>
						</div>
						<div class="placedetails">
							<?php
							if(strpos($company['googlemapurl'],"https://www.google.com/")===0)
							{
							?>	
								<a href="<?php echo $company['googlemapurl'] ?>" target="_blank" class="pull-left" style="margin-top: 14px;color: black;"><i class="flaticon-pin"></i>
								Get Direction</a>		
							<?php	
							}
							else
							{
							?>
								<a href="<?php echo base_url('index.php/Home/error') ?>" target="_blank" class="pull-left" style="margin-top: 14px;color: black;"><i class="flaticon-pin"></i>
								Get Direction</a>
							<?php	
							}
							?>
							<span class="pull-right"><i class="flaticon-phone-call"></i>+<?php echo $company['contact']; ?></span>
						</div>
					</div>
		<?php	
			}
		?>
				</div>
			</div>
		<?php			
		}
	}

	public function more_info($companyid,$subcatid)
	{
		$product_result=$this->sm->fetchProduct($companyid,$subcatid);
		$company_result=$this->sm->fetchCompany($companyid);
		$morecontact_result=$this->sm->fetchMorecontact($companyid);
		$moreemail_result=$this->sm->fetchMoreemail($companyid);
		$cnt_product=$this->sm->cntproductByCompanyid($companyid);
		//$cnt_inquiry=$this->sm->cnt_inquiry($companyid);
		// if(isset($_SESSION['uname']))
		// {
			
			// $data=array(
			// 	"productinfo"=>$product_result,
			// 	"companyinfo"=>$company_result,
			// 	"morecontact"=>$morecontact_result,
			// 	"moreemail"=>$moreemail_result,
			// 	"pcnt"=>$cnt_product,
			// 	"sid"=>$subcatid,
			// 	"compid"=>$companyid
			// 	//"icnt"=>$cnt_inquiry
			// );
			// // echo "<script>";
			// // echo 'alert("Please Login to View your liked products")';
			// // echo "</script>";
			// $this->load->view("searchmore",$data);
		// }
		// else
		// {
			$data=array(
				"productinfo"=>$product_result,
				"companyinfo"=>$company_result,
				"morecontact"=>$morecontact_result,
				"moreemail"=>$moreemail_result,
				"pcnt"=>$cnt_product,
				"sid"=>$subcatid,
				"compid"=>$companyid
				//"icnt"=>$cnt_inquiry
			);
			// echo "<script>";
			// echo 'alert("Please Login to View your liked products")';
			// echo "</script>";
			$this->load->view("searchmore",$data);	
		//}
	}

	public function loadproductmail($pid,$cid,$sid)
	{
		$pinfo=$this->sm->fetchproductbypid($pid);
		//$mail_info=$this->sm->fetchMail($cid);
		?>
			<form  method="post" action="<?php echo site_url("Search/addinquiry/$cid/$pid/$sid");?>">
 			<div id="" style="margin-left: 100px;">
	 			<h2 style="margin-top: 20px; margin-left: 200px; color: skyblue;">SEND INQUIRY</h2>

				<div class="fieldformy col-lg-6" style="width: 900px; margin-top:10px;">			
					<span style="margin-left: 110px; font-family: sans-serif; font-size: 15px;  color: skyblue;">Offer Price:</span><span id="txtamt" style="margin-left: 190px; margin-top: -17px; font-size: 15px;  color: skyblue;"><?php echo $pinfo['min_price']?></span>
					<!-- <div class="slidecontainer" style="margin-top: 30px;">
					  <input type="range" class="slider" id="myRange" min="<?php echo $pinfo['min_price']?>" max="<?php echo $pinfo['max_price']?>" value="<?php echo $pinfo['min_price']?>" onchange="slider_price(this)">
					  <p style="text-align: center;">Value: <span id="demo"></span></p>
					</div> -->			
					<div class="rslider">
						<amino-slider class="slider" data-min="0" data-max="100" data-value="10">
							<!-- <div class="am-thumb" style="left: 74px;"></div> -->
							<input type="range" name="txtprice" min="<?php echo $pinfo['min_price']?>" max="<?php echo $pinfo['max_price']?>" step="0" value="<?php echo $pinfo['min_price']?>" style="width: 300px;" onchange="load_amount(this.value);"><br>
							<span style="color: skyblue;"><?php echo $pinfo['min_price']?></span>
							<span style="margin-left: 200px; color: skyblue;"><?php echo $pinfo['max_price']?></span>
							<!-- <div class="am-tooltip-active-state" style="top: -38px; left: 33.3px; margin-left: -10px;">10</div> -->
						</amino-slider>
					</div>		
				</div>							
				<div class="fieldformy" style="margin-top:20px;">			
					<span style="margin-left: 270px; font-family: sans-serif; font-size: 15px;  color: skyblue;">Message</span>
					<textarea style="text-align: center; margin-left: -50px; width: 100%; height: 150px; resize: none; " name="txtmsg" required placeholder="Enter your Inquiry...">
							  					
					</textarea>				
				</div>
			<div>
			<div class="col-lg-12">
				<div class="formaction">
					<input type="submit" class="updatebtn" value="SEND MAIL" style="margin-top: 16px; margin-left: 125px; width: 50%; height: 12%;">
				</div>
			</div>			
 		</form>
		<?php


	}

	public function addinquiry($cmpid,$pid,$sid)
	{
		$product_result=$this->sm->fetchProduct($cmpid,$sid);
		$company_result=$this->sm->fetchCompany($cmpid);
		$morecontact_result=$this->sm->fetchMorecontact($cmpid);
		$moreemail_result=$this->sm->fetchMoreemail($cmpid);
		$cnt_product=$this->sm->cntproductByCompanyid($cmpid);
		//$cnt_inquiry=$this->sm->cnt_inquiry($companyid);
		$data=array(
			"productinfo"=>$product_result,
			"companyinfo"=>$company_result,
			"morecontact"=>$morecontact_result,
			"moreemail"=>$moreemail_result,
			"pcnt"=>$cnt_product,
			"sid"=>$sid
			//"icnt"=>$cnt_inquiry
		);

		//email sending
		if(isset($_SESSION['uid']))
		{
			if(!empty($moreemail_result))
			{
				$mail=$moreemail_result['email'];
				$mail2=$company_result['email'];
			}
			else
			{
				$mail2=$company_result['email'];	
			}
			$result=$this->sm->fetchcompanyfromemail($mail2);
			$msg=$this->input->post("txtmsg");
			$price=$this->input->post("txtprice");
			$status="0";
					
			$info=array(
				"productid"=>$pid,
				"from_userid"=>$_SESSION['uid'],
				"to_userid"=>$company_result['userid'],
				"companyid"=>$cmpid,
				"message"=>$msg,
				"offerprice"=>$price,
				"inquiry_status"=>0
			);
			$this->sm->insertInquiry($info);
			$ndata=array(
				"notificationid"=>0,
				"from_userid"=>$_SESSION['uid'],
				"to_userid"=>$company_result['userid'],
				"productid"=>$pid,
				"comment"=>$msg,
				"cmnt_status"=>0,
				"type"=>"i"
			);
			$this->sm->addInq($ndata);
			if(empty($mail))
			{
				$this->send_inquiry_email($mail2,$pid,$msg);
			}
			else
			{
				$this->send_inquiry_email($mail,$pid,$msg);
				$this->send_inquiry_email2($mail2,$pid,$msg);
			}

		}
		else
		{
			echo "<script>";
			echo "alert('Please Login to send Inquiry!')";
			echo "</script>";			
			$this->load->view("searchmore",$data);
		}
		
	}

	public function send_inquiry_email($email,$pid,$msg)
	{
		$pinfo=$this->sm->fetchproductbypid($pid);
		$from=$_SESSION['email'];
		$this->load->library('email');
		$email_code=md5($email);
		
		$emailContent = '<!DOCTYPE><html><head></head><body><table width="600px" style="border:1px solid #cccccc;margin: auto;border-spacing:0;"><tr><td style="background:#000000;padding-left:3%"></td></tr>';
    	$emailContent .='<tr><td style="height:20px"></td></tr>';
    	$emailContent .= $msg;
    	$emailContent .= "Please reply me on ".$from;
	    $emailContent .='<tr><td style="height:20px"></td></tr>';

		$config['protocol']='smtp';
		$config['smtp_host']='ssl://smtp.gmail.com';
		$config['smtp_port']='465';
		$config['smtp_timeout']='60';

		$config['smtp_user']='textilewarehouse1724@gmail.com';
		$config['smtp_pass']='TEXTILEWAREHOUSE2417';

		$config['charset']='utf-8';
		$config['newline']="\r\n";
		$config['mailtype']='html';
		$config['validation']=TRUE;

		//$this->load->library('email',$config);		
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->from($from);
		$this->email->to($email);
		$this->email->subject('Inquiry for '.$pinfo['title']);
		$this->email->message($emailContent);
		$this->email->send();

		// $_SESSION['success_msg']="Email Has Been Sent!!Check It Out";

		// echo $_SESSION['success_msg'];
		echo "<script>";
		echo "alert('Inquiry Successfully Sent!')";
		echo "</script>";
		$companyid=$pinfo['companyid'];
		$subcatid=$pinfo['subcategoryid'];
		$product_result=$this->sm->fetchProduct($companyid,$subcatid);
		$company_result=$this->sm->fetchCompany($companyid);
		$morecontact_result=$this->sm->fetchMorecontact($companyid);
		$moreemail_result=$this->sm->fetchMoreemail($companyid);
		$cnt_product=$this->sm->cntproductByCompanyid($companyid);
		//$cnt_inquiry=$this->sm->cnt_inquiry($companyid);
		$data=array(
			"productinfo"=>$product_result,
			"companyinfo"=>$company_result,
			"morecontact"=>$morecontact_result,
			"moreemail"=>$moreemail_result,
			"pcnt"=>$cnt_product,
			"sid"=>$subcatid
			//"icnt"=>$cnt_inquiry
		);
		$this->load->view("searchmore",$data);
	}

		public function send_inquiry_email2($email,$pid,$msg)
	{
		$pinfo=$this->sm->fetchproductbypid($pid);
		$from=$_SESSION['email'];
		$this->load->library('email');
		$email_code=md5($email);
		
		$emailContent = '<!DOCTYPE><html><head></head><body><table width="600px" style="border:1px solid #cccccc;margin: auto;border-spacing:0;"><tr><td style="background:#000000;padding-left:3%"></td></tr>';
    	$emailContent .='<tr><td style="height:20px"></td></tr>';
    	$emailContent .= $msg;
    	$emailContent .= "Please reply me on ".$from;
	    $emailContent .='<tr><td style="height:20px"></td></tr>';

		$config['protocol']='smtp';
		$config['smtp_host']='ssl://smtp.gmail.com';
		$config['smtp_port']='465';
		$config['smtp_timeout']='60';

		$config['smtp_user']='textilewarehouse1724@gmail.com';
		$config['smtp_pass']='TEXTILEWAREHOUSE2417';

		$config['charset']='utf-8';
		$config['newline']="\r\n";
		$config['mailtype']='html';
		$config['validation']=TRUE;

		//$this->load->library('email',$config);		
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->from($from);
		$this->email->to($email);
		$this->email->subject('Inquiry for '.$pinfo['title']);
		$this->email->message($emailContent);
		$this->email->send();

		// $_SESSION['success_msg']="Email Has Been Sent!!Check It Out";

		// echo $_SESSION['success_msg'];
		echo "<script>";
		echo "alert('Inquiry Successfully Sent!')";
		echo "</script>";
		$companyid=$pinfo['companyid'];
		$subcatid=$pinfo['subcategoryid'];
		$product_result=$this->sm->fetchProduct($companyid,$subcatid);
		$company_result=$this->sm->fetchCompany($companyid);
		$morecontact_result=$this->sm->fetchMorecontact($companyid);
		$moreemail_result=$this->sm->fetchMoreemail($companyid);
		$cnt_product=$this->sm->cntproductByCompanyid($companyid);
		//$cnt_inquiry=$this->sm->cnt_inquiry($companyid);
		$data=array(
			"productinfo"=>$product_result,
			"companyinfo"=>$company_result,
			"morecontact"=>$morecontact_result,
			"moreemail"=>$moreemail_result,
			"pcnt"=>$cnt_product,
			"sid"=>$subcatid
			//"icnt"=>$cnt_inquiry
		);
		$this->load->view("searchmore",$data);
	}

	public function slider()
	{
		$this->load->view("test");
	}

	public function addwishlist($pid,$cid,$sid)
	{
		if(isset($_SESSION['uid']))
		{
			$uid=$_SESSION['uid'];			
			$cnt=$this->sm->fetchfromwishlist_cnt($uid,$pid);			
			if($cnt==0)
			{
				$data=array(
					"productid"=>$pid,
					"userid"=>$uid
				);
				$this->sm->insertinWishlist($data);
				$productinfo=$this->sm->fetchProduct($cid,$sid);
				$winfo=$this->sm->fetchfromwishlistbyuserid($uid);	
				$product_result=$this->sm->fetchproductidfromproducttb($cid,$sid);
				foreach ($productinfo as $p) 
				{
					foreach ($winfo as $w) 
					{						
						if($p['productid']==$w['productid'])
						{							
						?>
							<div class="row">
								<div class="col-lg-12 fakeScroll fakeScroll--inside">
									<div class="places s2">
										<div class="boxplaces">
											<div class="placeinfos">
												<h3 style="color: white;"><?php echo $p['title'] ?>
												<div style=" margin-top: -25px;">
													<button style="background-color: black; margin-left: -25px;" value="<?php echo $p['productid'];?>" onclick="product_like(this.value)"><i class="fa fa-heart" style="margin-left: 285px;"></i></button>
												</div>		
												</h3>
												<h6>Min Price : <?php echo "Rs" . $p['min_price']; ?>
													<?php echo "<br>"; ?>
													Max Price : <?php echo "Rs" . $p['max_price']; ?>
												</h6>
												<a href="<?php echo base_url('index.php/Search/loadmoreinfo/'.$p['productid'].'/'.$p['companyid']) ?>" target="_blank" style="border: 1px solid black; padding: 7px;color: white;background-color: black;width: 80px;border-radius: 10px;box-shadow: 3px 3px 3px grey;cursor: pointer;width: 100px;margin-left: 10px;">More Info</a>

												<span id="<?php echo $p['productid']?>" onclick="load_mail(this)" style="border: 1px solid black; padding: 7px;color: white;background-color: black;width: 100px;border-radius: 10px;box-shadow: 3px 3px 3px grey;cursor: pointer; margin-left: 120px;">Make Inquiry
												</span>	
						
											</div>
										</div>
										<div class="placethumb">
											<img src="<?php echo base_url('resources/user/products/'.$p['pro_img']) ?>" alt="" style="height: 400px;"/>
										</div>
									</div>
											
								</div>
							</div>
						<?php
						}						
					}
				}			

				foreach ($product_result as $p) 
				{
				?>
					<div class="row">
								<div class="col-lg-12 fakeScroll fakeScroll--inside">
									<div class="places s2">
										<div class="boxplaces">
											<div class="placeinfos">
												<h3 style="color: white;"><?php echo $p['title'] ?>
												<div style=" margin-top: -25px;">
													<button style="background-color: black; margin-left: -25px;" value="<?php echo $p['productid'];?>" onclick="product_like(this.value)"><i class="flaticon-heart" style="margin-left: 285px;"></i></button>
												</div>		
												</h3>
												<h6>Min Price : <?php echo "Rs" . $p['min_price']; ?>
													<?php echo "<br>"; ?>
													Max Price : <?php echo "Rs" . $p['max_price']; ?>
												</h6>
												<a href="<?php echo base_url('index.php/Search/loadmoreinfo/'.$p['productid'].'/'.$p['companyid']) ?>" target="_blank" style="border: 1px solid black; padding: 7px;color: white;background-color: black;width: 80px;border-radius: 10px;box-shadow: 3px 3px 3px grey;cursor: pointer;width: 100px;margin-left: 10px;">More Info</a>

												<span id="<?php echo $p['productid']?>" onclick="load_mail(this)" style="border: 1px solid black; padding: 7px;color: white;background-color: black;width: 100px;border-radius: 10px;box-shadow: 3px 3px 3px grey;cursor: pointer; margin-left: 120px;">Make Inquiry
												</span>	
						
											</div>
										</div>
										<div class="placethumb">
											<img src="<?php echo base_url('resources/user/products/'.$p['pro_img']) ?>" alt="" style="height: 400px;"/>
										</div>
									</div>
											
								</div>
							</div>
				<?php
				}
			}
			if($cnt==1)
			{
				$uid=$_SESSION['uid'];
				$winfo=$this->sm->fetchfromwishlist($uid,$pid);
				$wid=$winfo['wishlistid'];
				$this->sm->deletefromwishlist($wid);
				$productinfo=$this->sm->fetchProduct($cid,$sid);
				$winfo=$this->sm->fetchfromwishlistbyuserid($uid);	
				$product_result=$this->sm->fetchproductidfromproducttb($cid,$sid);
				foreach ($productinfo as $p) 
				{
					foreach ($winfo as $w) 
					{						
						if($p['productid']==$w['productid'])
						{
						?>
						<div class="row">										
							<div class="col-lg-12 fakeScroll fakeScroll--inside">
								<div class="places s2">
									<div class="boxplaces">
										<div class="placeinfos">
											<h3 style="color: white;"><?php echo $p['title'] ?>
											<div style=" margin-top: -25px;">
												<button style="background-color: black; margin-left: -25px;" value="<?php echo $p['productid'];?>" onclick="product_like(this.value)"><i class="fa fa-heart" style="margin-left: 285px;"></i></button>
											</div>		
											</h3>
											<h6>Min Price : <?php echo "Rs" . $p['min_price']; ?>
												<?php echo "<br>"; ?>
												Max Price : <?php echo "Rs" . $p['max_price']; ?>
											</h6>
											<a href="<?php echo base_url('index.php/Search/loadmoreinfo/'.$p['productid'].'/'.$p['companyid']) ?>" target="_blank" style="border: 1px solid black; padding: 7px;color: white;background-color: black;width: 80px;border-radius: 10px;box-shadow: 3px 3px 3px grey;cursor: pointer;width: 100px;margin-left: 10px;">More Info</a>

											<span id="<?php echo $p['productid']?>" onclick="load_mail(this)" style="border: 1px solid black; padding: 7px;color: white;background-color: black;width: 100px;border-radius: 10px;box-shadow: 3px 3px 3px grey;cursor: pointer; margin-left: 120px;">		Make Inquiry
											</span>	
						
										</div>
									</div>
									<div class="placethumb">
										<img src="<?php echo base_url('resources/user/products/'.$p['pro_img']) ?>" alt="" style="height: 400px;"/>
									</div>
								</div>
										
							</div>									
						</div>									
						<?php
						}
					}
				}

				foreach ($product_result as $p) 
				{
				?>
					<div class="row">
						<div class="col-lg-12 fakeScroll fakeScroll--inside">
							<div class="places s2">
								<div class="boxplaces">
									<div class="placeinfos">
										<h3 style="color: white;"><?php echo $p['title'] ?>
											<div style=" margin-top: -25px;">
												<button style="background-color: black; margin-left: -25px;" value="<?php echo $p['productid'];?>" onclick="product_like(this.value)"><i class="flaticon-heart" style="margin-left: 285px;"></i></button>
											</div>		
										</h3>
										<h6>Min Price : <?php echo "Rs" . $p['min_price']; ?>
											<?php echo "<br>"; ?>
											Max Price : <?php echo "Rs" . $p['max_price']; ?>
										</h6>
										<a href="<?php echo base_url('index.php/Search/loadmoreinfo/'.$p['productid'].'/'.$p['companyid']) ?>" target="_blank" style="border: 1px solid black; padding: 7px;color: white;background-color: black;width: 80px;border-radius: 10px;box-shadow: 3px 3px 3px grey;cursor: pointer;width: 100px;margin-left: 10px;">More Info</a>

										<span id="<?php echo $p['productid']?>" onclick="load_mail(this)" style="border: 1px solid black; padding: 7px;color: white;background-color: black;width: 100px;border-radius: 10px;box-shadow: 3px 3px 3px grey;cursor: pointer; margin-left: 120px;">Make Inquiry
										</span>	
									</div>
								</div>
								<div class="placethumb">
									<img src="<?php echo base_url('resources/user/products/'.$p['pro_img']) ?>" alt="" style="height: 400px;"/>
								</div>
							</div>
									
						</div>
					</div>
				<?php
				}
			}
		}
		else
		{			
			$companyid=$pinfo['companyid'];
			$subcatid=$pinfo['subcategoryid'];
			$product_result=$this->sm->fetchProduct($companyid,$subcatid);
			$company_result=$this->sm->fetchCompany($companyid);
			$morecontact_result=$this->sm->fetchMorecontact($companyid);
			$moreemail_result=$this->sm->fetchMoreemail($companyid);
			$cnt_product=$this->sm->cntproductByCompanyid($companyid);
			//$cnt_inquiry=$this->sm->cnt_inquiry($companyid);
			$data=array(
				"productinfo"=>$product_result,
				"companyinfo"=>$company_result,
				"morecontact"=>$morecontact_result,
				"moreemail"=>$moreemail_result,
				"pcnt"=>$cnt_product,
				"sid"=>$subcatid
				//"icnt"=>$cnt_inquiry
			);
			$this->load->view("searchmore",$data);
		}
	}

	public function show_like($cid,$sid)
	{
		if(isset($_SESSION['uid']))
		{
			$uid=$_SESSION['uid'];
			$productinfo=$this->sm->fetchProduct($cid,$sid);
			$winfo=$this->sm->fetchfromwishlistbyuserid($uid);	
			$product_result=$this->sm->fetchproductidfromproducttb($cid,$sid);
			foreach ($productinfo as $p) 
			{
				foreach ($winfo as $w) 
				{						
					if($p['productid']==$w['productid'])
					{							
					?>
						<div class="row">
							<div class="col-lg-12 fakeScroll fakeScroll--inside">
								<div class="places s2">
									<div class="boxplaces">
										<div class="placeinfos">
											<h3 style="color: white;"><?php echo $p['title'] ?>
												<div style=" margin-top: -25px;">
													<button style="background-color: black; margin-left: -25px;" value="<?php echo $p['productid'];?>" onclick="product_like(this.value)"><i class="fa fa-heart" style="margin-left: 285px;"></i></button>
												</div>		
											</h3>
											<h6>Min Price : <?php echo "Rs" . $p['min_price']; ?>
												<?php echo "<br>"; ?>
												Max Price : <?php echo "Rs" . $p['max_price']; ?>
											</h6>
											<a href="<?php echo base_url('index.php/Search/loadmoreinfo/'.$p['productid'].'/'.$p['companyid']) ?>" target="_blank" style="border: 1px solid black; padding: 7px;color: white;background-color: black;width: 80px;border-radius: 10px;box-shadow: 3px 3px 3px grey;cursor: pointer;width: 100px;margin-left: 10px;">More Info</a>

											<span id="<?php echo $p['productid']?>" onclick="load_mail(this)" style="border: 1px solid black; padding: 7px;color: white;background-color: black;width: 100px;border-radius: 10px;box-shadow: 3px 3px 3px grey;cursor: pointer; margin-left: 120px;">Make Inquiry
											</span>	
						
										</div>
									</div>
									<div class="placethumb">
										<img src="<?php echo base_url('resources/user/products/'.$p['pro_img']) ?>" alt="" style="height: 400px;"/>
									</div>
								</div>
							</div>
						</div>
						<?php
						}						
					}
				}			

				foreach ($product_result as $p) 
				{
				?>
					<div class="row">
						<div class="col-lg-12 fakeScroll fakeScroll--inside">
							<div class="places s2">
								<div class="boxplaces">
									<div class="placeinfos">
										<h3 style="color: white;"><?php echo $p['title'] ?>
											<div style=" margin-top: -25px;">
												<button style="background-color: black; margin-left: -25px;" value="<?php echo $p['productid'];?>" onclick="product_like(this.value)"><i class="flaticon-heart" style="margin-left: 285px;"></i></button>
											</div>		
										</h3>
										<h6>Min Price : <?php echo "Rs" . $p['min_price']; ?>
											<?php echo "<br>"; ?>
											Max Price : <?php echo "Rs" . $p['max_price']; ?>
										</h6>
										<a href="<?php echo base_url('index.php/Search/loadmoreinfo/'.$p['productid'].'/'.$p['companyid']) ?>" target="_blank" style="border: 1px solid black; padding: 7px;color: white;background-color: black;width: 80px;border-radius: 10px;box-shadow: 3px 3px 3px grey;cursor: pointer;width: 100px;margin-left: 10px;">More Info</a>

										<span id="<?php echo $p['productid']?>" onclick="load_mail(this)" style="border: 1px solid black; padding: 7px;color: white;background-color: black;width: 100px;border-radius: 10px;box-shadow: 3px 3px 3px grey;cursor: pointer; margin-left: 120px;">Make Inquiry
										</span>	
									</div>
								</div>
								<div class="placethumb">
									<img src="<?php echo base_url('resources/user/products/'.$p['pro_img']) ?>" alt="" style="height: 400px;"/>
								</div>
							</div>
																		
						</div>
					</div>
				<?php
				}
		}
		else
		{			
			$product_result=$this->sm->fetchProduct($cid,$sid);
			$company_result=$this->sm->fetchCompany($cid);
			$morecontact_result=$this->sm->fetchMorecontact($cid);
			$moreemail_result=$this->sm->fetchMoreemail($cid);
			$cnt_product=$this->sm->cntproductByCompanyid($cid);
			//$cnt_inquiry=$this->sm->cnt_inquiry($companyid);
			$data=array(
				"productinfo"=>$product_result,
				"companyinfo"=>$company_result,
				"morecontact"=>$morecontact_result,
				"moreemail"=>$moreemail_result,
				"pcnt"=>$cnt_product,
				"sid"=>$sid
				//"icnt"=>$cnt_inquiry
			);
			$this->load->view("searchmore",$data);
		}
	}

	public function test()
	{
		$product_result=$this->sm->fetchproductidfromproducttb();
		$data=array(
			"product"=>$product_result
		);
		$this->load->view("testing",$data);
	}

	public function loadcomment($pid)
	{
		$comment_result=$this->sm->fetchComment($pid);
		if(empty($comment_result))
		{
		?>
			<h4>No Comment Found</h4>
		<?php
		}
		else
		{

		foreach ($comment_result as $c) 
		{
			$cr=$this->sm->fetchCreply($c['commentid']);
			if($pid==$c['productid'])
			{
				$pic=$this->sm->fetchuser($c['userid']);
				if($pic['profilepic']!="null")
				{
				?>
					<div class="row" style="margin-top: 5px;">
						<div class="col-lg-2">
							<img src="<?php echo base_url('resources/user/profile_pic/'.$pic['profilepic']) ?>" style="height: 40px;width: 40px;border-radius: 20px;">
						</div>
						<div class="col-lg-4">
						<?php
						if(empty($cr))
						{
						?>
							<b style="font-weight: bold;margin-right: 200px;"><?php echo $pic['username']; ?></b>
							<br>
							<?php echo $c['comment']; ?>	
						<?php	
						}
						else
						{
						?>
							<b style="font-weight: bold;"><?php echo $pic['username']; ?></b>
							<br>
							<?php echo $c['comment']; ?>
						<?php
						}
						?>
						</div>
					</div>
					<?php
						if(!empty($cr))
						{
						?>
							<div class="column" style="margin-left: 120px;border:1px solid white;padding: 4px;height: 30px;width: 150px;border-radius: 10px;box-shadow: 2px 2px 1px 2px grey;">
								<h6>Reply : <?php echo $cr['commentreply']; ?></h6>
							</div>
						<?php	
						}
				}
				else
				{
				?>
					<div class="row" style="margin-top: 5px;">
						<div class="col-lg-2">
							<img src="<?php echo base_url('resources/user/defaultpic.jpg') ?>" style="height: 40px;width: 40px;border-radius: 20px;">
						</div>
						<div class="col-lg-4">
						<?php
						if(empty($cr))
						{
						?>
							<b style="font-weight: bold;margin-right: 200px;"><?php echo $pic['username']; ?></b>
							<br>
							<?php echo $c['comment']; ?>	
						<?php	
						}
						else
						{
						?>
							<b style="font-weight: bold;"><?php echo $pic['username']; ?></b>
							<br>
							<?php echo $c['comment']; ?>
						<?php
						}
						?>	
						</div>
					</div>
					<?php
						if(!empty($cr))
						{
						?>
							<div class="column" style="margin-left: 100px;">
								<b>Reply : </b><?php echo $cr['commentreply']; ?>
							</div>
						<?php	
						}
				}	
			}
			else
			{
	?>	
				<div class="row">
					<div class="col-lg-4">
						<?php echo "No Comment Found";?>
					</div>
				</div>		
	<?php			
			}
		}
	}
	}

	public function comment($pid,$text,$uid)
	{
		if(empty($_SESSION['uid'])){
			echo "<u>Login Required</u>";
		?>
			<br><br>
			<a href="<?php echo base_url('index.php/Home/loginpage') ?>" style="padding: 5px;background-color: black;color: white;border-radius: 10px;">Click Here For Log-in</a>
		<?php	
		}
		else
		{
			$data=array(
				"commentid"=>0,
				"productid"=>$pid,
				"userid"=>$_SESSION['uid'],
				"comment"=>$text,
			);
			$this->sm->addComment($data);
			$notification=array(
				"notificationid"=>0,
				"productid"=>$pid,
				"from_userid"=>$_SESSION['uid'],
				"to_userid"=>$uid,
				"comment"=>$text,
				"type"=>"c"	
			);
			$this->sm->add_CNotification($notification);
			$ans=$this->sm->fetchuser($_SESSION['uid']);
			if($ans['profilepic']!="null")
			{
			?>
					<div class="row" style="margin-top: 5px;">
						<div class="col-lg-4">
							<img src="<?php echo base_url('resources/user/profile_pic/'.$ans['profilepic']) ?>" style="height: 40px;width: 40px;border-radius: 20px;">
						</div>
						<div class="col-lg-4">
							<b style="font-weight: bold;"><?php echo $ans['username']; ?></b>
							<br>
							<?php echo $text; ?>
						</div>
					</div>		
			<?php		
			}
			else
			{
			?>
					<div class="row" style="margin-top: 5px;">
						<div class="col-lg-2">
							<img src="<?php echo base_url('resources/user/defaultpic.jpg') ?>" style="height: 40px;width: 40px;border-radius: 20px;">
						</div>
						<div class="col-lg-4">
							<b style="font-weight: bold;"><?php echo $ans['username']; ?></b>
							<br>
							<?php echo $text; ?>
						</div>
					</div>
			<?php	
			}	
		}
	}

	public function loadmoreinfo($pid,$cid)
	{
		$company_result=$this->sm->fetchCompany($cid);
		$image_result=$this->sm->imageById($pid);
		$product_result=$this->sm->productById($pid);
		$data=array("pinfo"=>$product_result,"img"=>$image_result,"companyinfo"=>$company_result);
		$this->load->view("product_more",$data);
	}
}
?>


