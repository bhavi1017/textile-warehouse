<?php

class Services extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->model("servicesM","sm");
	}
	public function home($value='')
	{
	?>
			<h3><b  style="color: blue;"><u>Let's Have A Glance Of Our Services To Our Users/Visitors</u></b><br>
			<i style="font-size: 20px;">Platform For Finding Business And Marketting</i>	
			</h3>
			<br>
			<div>
				<b style="font-size: 28px;">
					Authentication Service
				</b>
				<p style="margin-left: 20px;margin-top: 5px;">
					To authorize access, the Web Services first attempt the credentials (user name and password) of the user account associated with the request. If this attempt fails, access is attempted through the credentials of the guest user account. If this attempt fails, the web services return a Basic HTTP authentication challenge to the requesting client, such as a web browser.
				</p>
			</div>
			<div>
				<b style="font-size: 28px;">
					Marketing Service
				</b>
				<p style="margin-left: 20px;margin-top: 5px;">
					This Service Provides You To Have A Marketing Of Your Registered [Authenticated] Companies And It's Product Which May Expand Your Business.Your Appropriate And Accute Details Would Lead Your Deal To Some Extent To Help Lead Your Business.
					You Can Connect With Your Dealers Through Inquiry And Mailing And Calling.Interesting Dealers Could Locate Your Direction.
				</p>
			</div>
			<div>
				<b style="font-size: 28px;">
					Searching Service
				</b>
				<p style="margin-left: 20px;margin-top: 5px;">
					This Service Would Help User Exploring More To Be Updated About Current Trends In A Textile World And Help User To Get Your Requirement Based Object.City Wise Searching And Location Tracking Would Be There.After Having Look At Your Required Object,User Can Either Make Inquiries Or Call To That Company Or can Mail To That Company  
				</p>
			</div>	
	<?php
	}
	public function authentication()
	{
	?>
		<div class="row">
			<div class="col-lg-6">
				<h4>Registration Page</h4>
				<img src="<?php echo base_url('resources/user/images/registration.png') ?>" style="height: 300px;width:100%;object-fit: cover;" onclick="loadImage(this)">
			</div>
			<div class="col-lg-6">
				<h4>Login Page</h4>
				<img src="<?php echo base_url('resources/user/images/login.png') ?>" style="height: 300px;width:100%;object-fit: cover;" onclick="loadImage(this)">
			</div>
		</div>
	<?php	
	}
	public function marketing()
	{
	?>
		<p>
			<h3 style="font-weight: bold;">What Does Marketing Mean</h3>
			Marketing refers to activities a company undertakes to promote the buying or selling of a product or service.
			This Website Is A Huge Platform For User To Grow The Business.It Provides Platform To Business Dealers To Have A Contact With Each Other.User Can Perform CRUD Operations For Companies And Products.User Can Interact With Dealers Using Contact And Other Information.And More Importantly Users Can <u>Promote Their Activities</u>. 
		</p>
		<br>
		<h5 style="padding: 5px;background-color: tomato;color: white;width: 220px;font-weight: bold;"><u>Prequisite</u>: User Authentication Required</h5>
		<br>
		<div class="row">
			<div class="col-lg-6">
				<img src="<?php echo base_url('resources/user/images/marketing1.png') ?>" style="height: 300px;width:100%;object-fit: cover;box-shadow: 3px 3px 5px 6px #111;margin-bottom: 20px;" onclick="loadImage(this)">
				<h6 style="text-align: center;font-weight: bold;">Dashboard Helps Users To Manage Their Activities.<br>
				Listing Helps In Marketing Of Products.<br>
				Inquiries Would Help In Inquiry Management.<br>
				Using Dashboard Users Can Add Companies
				</h6>
			</div>
			<div class="col-lg-6">
				<img src="<?php echo base_url('resources/user/images/marketing2.png') ?>" style="height: 300px;width:100%;object-fit: cover;box-shadow: 3px 3px 5px 6px #111;margin-bottom: 20px;" onclick="loadImage(this)">
				<h6 style="text-align: center;font-weight: bold;">
				Companies Could Be Managed And Updated With Dashboard Feature.<br>
				Products can Be Added By Clicking On Add Button	
				</h6>
			</div>
		</div>
	<?php	
	}
	public function profile()
	{
	?>
		<center>
			<h5 style="padding: 5px;background-color: tomato;color: white;width: 220px;font-weight: bold;"><u>Prequisite</u>: User Authentication Required</h5>
		</center>
		<div class="row">
			<div class="col-lg-6">
				<img src="<?php echo base_url('resources/user/images/p1.jpg') ?>" style="width: 100%;" onclick="loadImage(this)">
			</div>
			<div class="col-lg-6">
				<img src="<?php echo base_url('resources/user/images/p2.jpg') ?>" style="width: 100%;" onclick="loadImage(this)">
			</div>
		</div>
		<div class="row" style="margin-top: 30px;">
			<div class="col-lg-6">
				<img src="<?php echo base_url('resources/user/images/p3.jpg') ?>" style="width: 100%;" onclick="loadImage(this)">
			</div>
			<div class="col-lg-6">
				<img src="<?php echo base_url('resources/user/images/p4.jpg') ?>" style="width: 100%;" onclick="loadImage(this)">
			</div>
		</div>
	<?php	
	}
	public function searching()
	{
	?>
		<div class="row">
			<div class="col-lg-6">
				<img src="<?php echo base_url('resources/user/images/searching.png') ?>" height=500 width=500>
			</div>
			<div class="col-lg-4" style="margin-left: 30px;">
				<p>
					No Prequisite For searching Is Required.
				</p>
				<p>For Liking , Commenting , Inquiring User Must Log-In First</p>
			</div>
		</div>	
		<div class="row" style="margin-top: 100px;">
			<video controls autoplay style="height: 500px;width: 100%;">
				<source src="<?php echo base_url('resources/user/video/searching.mp4') ?>">
			</video>
		</div>
	<?php	
	}
}
?>