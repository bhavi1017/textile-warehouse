<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();
		$this->load->model("HomeM","hm");	
		$this->load->model("ProductM","pm");
		$this->load->model("profileM","pm1");		
	}
	public function loadCompany($numbers)
	{
		
	}
	public function notification($uid)
	{
		// $data=array("from_userid"=>$uid);
		$result=$this->hm->fetchcnoti($uid);
		?>
		<h6 style="margin-top: -25px;font-size: 30px;margin-left: 390px;margin-bottom: -5px;font-weight: bold;cursor: pointer;" onclick="closenoti()">&times;</h6>
		<?php
		foreach ($result as $r) 
		{
			if($r['type']=='c')
			{
			if($r['cmnt_status']==0)
			{
				$result_comment=$this->hm->fetchCommentId($r['from_userid'],$r['productid'],$r['comment']);
				//print_r($result_comment);
				//echo $r['from_userid'];
	?>
			<div id="noti" class="row" style="border-bottom: 0.5px solid grey;background-color: #E0E0E0;cursor: pointer;">
				<div class="col-lg-2">
					<?php
					if($r['profilepic']!="null")
					{
					?>
						<a href="<?php echo base_url('index.php/Home/loadNotireply/'.$r['productid'].'/'.$r['notificationid'].'/'.$r['from_userid'].'/'.$r['to_userid'].'/0/'.$result_comment['commentid']) ?>" style="color: black;">
						<img src="<?php echo base_url('resources/user/profile_pic/'.$r['profilepic']) ?>" height=40 width=40px style="border-radius: 20px;margin-bottom: 10px;margin-top: 15px;"></a>
					<?php	
					}
					else
					{
					?>
						<a href="<?php echo base_url('index.php/Home/loadNotireply/'.$r['productid'].'/'.$r['notificationid'].'/'.$r['from_userid'].'/'.$r['to_userid'].'/0/'.$result_comment['commentid']) ?>" style="color: black;">
						<img src="<?php echo base_url('resources/user/defaultpic.jpg') ?>" height=40 width=40px style="border-radius: 20px;margin-bottom: 10px;margin-top: 15px;"></a>
					<?php	
					}
					?>
				</div>
				<div class="col-lg-8">
					<b style="font-weight: bold;"><?php echo $r['username'] ?></b> Has Commented On Your Product <?php echo $r['title'] ?><br>
					Comment : <?php echo $r['comment']; ?>
				</div>
				<div class="col-lg-2">
					<i class="flaticon-dustbin" style="font-size: 12px;cursor: pointer;" onclick="removeNoti('<?php echo $r['notificationid'] ?>')">Remove</i>
				</div>
			</div>
	<?php
			}
			else
			{
				$result_comment=$this->hm->fetchCommentId($r['from_userid'],$r['productid'],$r['comment']);
	?>
			<div id="noti" class="row" style="border-bottom: 0.5px solid grey;cursor: pointer;">
				<div class="col-lg-2">
					<?php
					if($r['profilepic']!="null")
					{
					?>
						<a href="<?php echo base_url('index.php/Home/loadNotireply/'.$r['productid'].'/'.$r['notificationid'].'/'.$r['from_userid'].'/'.$r['to_userid'].'/0/'.$result_comment['commentid']) ?>" style="color: black;">
						<img src="<?php echo base_url('resources/user/profile_pic/'.$r['profilepic']) ?>" height=40 width=40px style="border-radius: 20px;margin-bottom: 10px;margin-top: 15px;"></a>
					<?php	
					}
					else
					{
					?>
						<a href="<?php echo base_url('index.php/Home/loadNotireply/'.$r['productid'].'/'.$r['notificationid'].'/'.$r['from_userid'].'/'.$r['to_userid'].'/0/'.$result_comment['commentid']) ?>" style="color: black;">
						<img src="<?php echo base_url('resources/user/defaultpic.jpg') ?>" height=40 width=40px style="border-radius: 20px;margin-bottom: 10px;margin-top: 15px;"></a>
					<?php	
					}
					?>
				</div>
				<div class="col-lg-8">
					<b style="font-weight: bold;"><?php echo $r['username'] ?></b> Has Commented On Your Product <?php echo $r['title'] ?><br>
					Comment : <?php echo $r['comment']; ?>
				</div>
				<div class="col-lg-2">
					<i class="flaticon-dustbin" style="font-size: 12px;cursor: pointer;" onclick="removeNoti('<?php echo $r['notificationid'] ?>')">Remove</i>
				</div>
			</div>
	<?php			
			}
			}
			else if($r['type']=='cr')
			{
				$cr=$this->hm->CRcmntId($r['from_userid'],$r['to_userid'],$r['comment']);
			if($r['cmnt_status']==0)
			{ 
	?>
			<div id="noti" class="row" style="border-bottom: 0.5px solid grey;background-color: #E0E0E0;cursor: pointer;">
				<div class="col-lg-2">
					<?php
					if($r['profilepic']!="null")
					{
					?>
						<a href="<?php echo base_url('index.php/Home/loadNotireply/'.$r['productid'].'/'.$r['notificationid'].'/'.$r['from_userid'].'/'.$r['to_userid'].'/1/'.$cr['commentid']) ?>" style="color: black;">
						<img src="<?php echo base_url('resources/user/profile_pic/'.$r['profilepic']) ?>" height=40 width=40px style="border-radius: 20px;margin-bottom: 10px;margin-top: 15px;"></a>
					<?php	
					}
					else
					{
					?>
						<a href="<?php echo base_url('index.php/Home/loadNotireply/'.$r['productid'].'/'.$r['notificationid'].'/'.$r['from_userid'].'/'.$r['to_userid'].'/1/'.$cr['commentid']) ?>" style="color: black;">
						<img src="<?php echo base_url('resources/user/defaultpic.jpg') ?>" height=40 width=40px style="border-radius: 20px;margin-bottom: 10px;margin-top: 15px;"></a>
					<?php	
					}
					?>
				</div>
				<div class="col-lg-8">
					<b style="font-weight: bold;"><?php echo $r['username'] ?></b> Has Replied On Your Comment<?php echo $r['title'] ?><br>
					Reply : <?php echo $r['comment']; ?>
				</div>
				<div class="col-lg-2">
					<i class="flaticon-dustbin" style="font-size: 12px;cursor: pointer;" onclick="removeNoti('<?php echo $r['notificationid'] ?>')">Remove</i>
				</div>
			</div>
			</a>
	<?php
			}
			else
			{
				$result_comment=$this->hm->fetchCommentId($r['from_userid'],$r['productid'],$r['comment']);
	?>
			<div id="noti" class="row" style="border-bottom: 0.5px solid grey;cursor: pointer;">
				<div class="col-lg-2">
					<?php
					if($r['profilepic']!="null")
					{
					?>
						<a href="<?php echo base_url('index.php/Home/loadNotireply/'.$r['productid'].'/'.$r['notificationid'].'/'.$r['from_userid'].'/'.$r['to_userid'].'/1/'.$cr['commentid']) ?>" style="color: black;">
						<img src="<?php echo base_url('resources/user/profile_pic/'.$r['profilepic']) ?>" height=40 width=40px style="border-radius: 20px;margin-bottom: 10px;margin-top: 15px;"></a>
					<?php	
					}
					else
					{
					?>
						<a href="<?php echo base_url('index.php/Home/loadNotireply/'.$r['productid'].'/'.$r['notificationid'].'/'.$r['from_userid'].'/'.$r['to_userid'].'/1/'.$cr['commentid']) ?>" style="color: black;">
						<img src="<?php echo base_url('resources/user/defaultpic.jpg') ?>" height=40 width=40px style="border-radius: 20px;margin-bottom: 10px;margin-top: 15px;"></a>
					<?php	
					}
					?>
				</div>
				<div class="col-lg-8">
					<b style="font-weight: bold;"><?php echo $r['username'] ?></b> Has Replied On Your Comment <?php echo $r['title'] ?><br>
					Comment : <?php echo $r['comment']; ?>
				</div>
				<div class="col-lg-2">
					<i class="flaticon-dustbin" style="font-size: 12px;cursor: pointer;" onclick="removeNoti('<?php echo $r['notificationid'] ?>')">Remove</i>
				</div>
			</div>
			</a>
	<?php			
			}
			}
			if($r['type']=='ir')
			{
			if($r['cmnt_status']==0)
			{
				$result_comment=$this->hm->fetchReplyId($r['from_userid'],$r['to_userid'],$r['comment']);
				//$inquiry_result=$this->hm->fetchInquiry($result_comment['inquiryid']);
	?>
			<div id="noti" class="row" style="border-bottom: 0.5px solid grey;background-color: #E0E0E0;cursor: pointer;">
				<div class="col-lg-2">
					<?php
					if($r['profilepic']!="null")
					{
					?>
						<a href="<?php echo base_url('index.php/Home/loadNotireply/'.$r['productid'].'/'.$r['notificationid'].'/'.$r['from_userid'].'/'.$r['to_userid'].'/2/'.$result_comment['replyid']) ?>" style="color: black;">
						<img src="<?php echo base_url('resources/user/profile_pic/'.$r['profilepic']) ?>" height=40 width=40px style="border-radius: 20px;margin-bottom: 10px;margin-top: 15px;"></a>
					<?php	
					}
					else
					{
					?>
						<a href="<?php echo base_url('index.php/Home/loadNotireply/'.$r['productid'].'/'.$r['notificationid'].'/'.$r['from_userid'].'/'.$r['to_userid'].'/2/'.$result_comment['replyid']) ?>" style="color: black;">
						<img src="<?php echo base_url('resources/user/defaultpic.jpg') ?>" height=40 width=40px style="border-radius: 20px;margin-bottom: 10px;margin-top: 15px;"></a>
					<?php	
					}
					?>
				</div>
				<div class="col-lg-8">
					<b style="font-weight: bold;"><?php echo $r['username'] ?></b> Has Reply For Inquiry Of <?php echo $r['title'] ?> Product<br>
					Inquiry Reply : <?php echo $r['comment']; ?>
				</div>
				<div class="col-lg-2">
					<i class="flaticon-dustbin" style="font-size: 12px;cursor: pointer;" onclick="removeNoti('<?php echo $r['notificationid'] ?>')">Remove</i>
				</div>
			</div>
	<?php
			}
			else
			{
				$result_comment=$this->hm->fetchReplyId($r['from_userid'],$r['to_userid'],$r['comment']);
				//$inquiry_result=$this->hm->fetchInquiry($result_comment['inquiryid']);
	?>
			<div id="noti" class="row" style="border-bottom: 0.5px solid grey;cursor: pointer;">
				<div class="col-lg-2">
					<?php
					if($r['profilepic']!="null")
					{
					?>
						<a href="<?php echo base_url('index.php/Home/loadNotireply/'.$r['productid'].'/'.$r['notificationid'].'/'.$r['from_userid'].'/'.$r['to_userid'].'/2/'.$result_comment['replyid']) ?>" style="color: black;">
						<img src="<?php echo base_url('resources/user/profile_pic/'.$r['profilepic']) ?>" height=40 width=40px style="border-radius: 20px;margin-bottom: 10px;margin-top: 15px;"></a>
					<?php	
					}
					else
					{
					?>
						<a href="<?php echo base_url('index.php/Home/loadNotireply/'.$r['productid'].'/'.$r['notificationid'].'/'.$r['from_userid'].'/'.$r['to_userid'].'/2/'.$result_comment['replyid']) ?>" style="color: black;">
						<img src="<?php echo base_url('resources/user/defaultpic.jpg') ?>" height=40 width=40px style="border-radius: 20px;margin-bottom: 10px;margin-top: 15px;"></a>
					<?php	
					}
					?>
				</div>
				<div class="col-lg-8">
					<b style="font-weight: bold;"><?php echo $r['username'] ?></b> Has Replied On Your Inquiry Of <?php echo $r['title'] ?> Product<br>
					Inquiry Reply : <?php echo $r['comment']; ?>
				</div>
				<div class="col-lg-2">
					<i class="flaticon-dustbin" style="font-size: 12px;cursor: pointer;" onclick="removeNoti('<?php echo $r['notificationid'] ?>')">Remove</i>
				</div>
			</div>
	<?php			
			}
			}
			if($r['type']=='i')
			{
			if($r['cmnt_status']==0)
			{
				$result_comment=$this->hm->selectinquiry($r['from_userid'],$r['to_userid'],$r['comment']);
	?>
			<div id="noti" class="row" style="border-bottom: 0.5px solid grey;background-color: #E0E0E0;cursor: pointer;">
				<div class="col-lg-2">
					<?php
					if($r['profilepic']!="null")
					{
					?>
						<a href="<?php echo base_url('index.php/Home/loadNotireply/'.$r['productid'].'/'.$r['notificationid'].'/'.$r['from_userid'].'/'.$r['to_userid'].'/3/'.$result_comment['inquiryid']) ?>" style="color: black;">
						<img src="<?php echo base_url('resources/user/profile_pic/'.$r['profilepic']) ?>" height=40 width=40px style="border-radius: 20px;margin-bottom: 10px;margin-top: 15px;"></a>
					<?php	
					}
					else
					{
					?>
						<a href="<?php echo base_url('index.php/Home/loadNotireply/'.$r['productid'].'/'.$r['notificationid'].'/'.$r['from_userid'].'/'.$r['to_userid'].'/3/'.$result_comment['inquiryid']) ?>" style="color: black;">
						<img src="<?php echo base_url('resources/user/defaultpic.jpg') ?>" height=40 width=40px style="border-radius: 20px;margin-bottom: 10px;margin-top: 15px;"></a>
					<?php	
					}
					?>
				</div>
				<div class="col-lg-8">
					<b style="font-weight: bold;"><?php echo $r['username'] ?></b> Has Inquired For Product <?php echo $r['title'] ?> Product<br>
					Inquiry : <?php echo $r['comment']; ?>
				</div>
				<div class="col-lg-2">
					<i class="flaticon-dustbin" style="font-size: 12px;cursor: pointer;" onclick="removeNoti('<?php echo $r['notificationid'] ?>')">Remove</i>
				</div>
			</div>
	<?php
			}
			else
			{
				$result_comment=$this->hm->selectinquiry($r['from_userid'],$r['to_userid'],$r['comment']);
				//$inquiry_result=$this->hm->fetchInquiry($result_comment['inquiryid']);
	?>
			<div id="noti" class="row" style="border-bottom: 0.5px solid grey;cursor: pointer;">
				<div class="col-lg-2">
					<?php
					if($r['profilepic']!="null")
					{
					?>
						<a href="<?php echo base_url('index.php/Home/loadNotireply/'.$r['productid'].'/'.$r['notificationid'].'/'.$r['from_userid'].'/'.$r['to_userid'].'/3/'.$result_comment['inquiryid']) ?>" style="color: black;">
						<img src="<?php echo base_url('resources/user/profile_pic/'.$r['profilepic']) ?>" height=40 width=40px style="border-radius: 20px;margin-bottom: 10px;margin-top: 15px;"></a>
					<?php	
					}
					else
					{
					?>
						<a href="<?php echo base_url('index.php/Home/loadNotireply/'.$r['productid'].'/'.$r['notificationid'].'/'.$r['from_userid'].'/'.$r['to_userid'].'/3/'.$result_comment['inquiryid']) ?>" style="color: black;">
						<img src="<?php echo base_url('resources/user/defaultpic.jpg') ?>" height=40 width=40px style="border-radius: 20px;margin-bottom: 10px;margin-top: 15px;"></a>
					<?php	
					}
					?>
				</div>
				<div class="col-lg-8">
					<b style="font-weight: bold;"><?php echo $r['username'] ?></b> Has Inquired For Product <?php echo $r['title'] ?> Product<br>
					Inquiry : <?php echo $r['comment']; ?>
				</div>
				<div class="col-lg-2">
					<i class="flaticon-dustbin" style="font-size: 12px;cursor: pointer;" onclick="removeNoti('<?php echo $r['notificationid'] ?>')">Remove</i>
				</div>
			</div>
	<?php			
			}
			}
		}//foreach	
	}
	public function cntCmntNotification($uid)
	{
		$cmnt_noti=$this->hm->fetch_cmnt_noti_cnt($uid);
		echo $cmnt_noti;
	}

	public function index()
	{
		$cinfo=$this->hm->selectallcat();

		$temp=array(
			"cat"=>$cinfo
		);		
		$this->load->view("home",$temp);
	}

	public function loadsubcatbycatid($cid)
	{
		$data=array(
			"categoryid"=>$cid
		);
		$sinfo=$this->hm->selectsubcatbyid($data);		
		echo "<option value=-1>Select a sub category </option> ";
		foreach ($sinfo as $s) 
		{
		?>
			<option value="<?php echo $s->subcategoryid;?>"><?php echo $s->subcategoryname;?></option>
		<?php
		}
	}

	public function adduser()
	{
		static $cnt=0;
		$image="";
		//fetch image
		if((!empty($_FILES['fup']['name'])) && (($_FILES['fup']['type']=="image/jpeg") || ($_FILES['fup']['type']=="image/jpg") || ($_FILES['fup']['type']=="image/png")))
		{
			$image=$_FILES['fup']['name'];
			copy($_FILES['fup']['tmp_name'],"C:/wamp64/www/textile/resources/user/profile_pic/".$image);
			$_SESSION['profilepic']=$_FILES['fup']['name'];
		}
		elseif(empty($_FILES['fup']['name']))
		{
			$image="null";
			$_SESSION['profilepic']=$image;
		}
		else
		{
			$image="**Incorrect File Type**";
			$cnt++;
		}

		//load category 
		$cinfo=$this->hm->selectallcat();
		$temp=array(
			"cat"=>$cinfo,
			"errorImage"=>$image
		);

		//insert user+
		if($cnt==0)
		{
			$data=array(
				"username"=>$this->input->post("txtuname"),
				"password"=>$this->input->post("txtpass"),
				"email"=>$this->input->post("txtmail"),
				"profilepic"=>$image
			);
			$this->hm->insertuser($data);	
		}
		$this->load->view("home",$temp);
	}
	public function error($value='')
	{
		$this->load->view("error");
	}

	public function loaduser()
	{
		$data=array(
			"username"=>$this->input->post("txtname"),			
			"password"=>$this->input->post("txtpwd"),
			"block"=>0
		);

		$uinfo=$this->hm->selectuser($data);

		if(count($uinfo)>0)
		{
			$_SESSION['uid']=$uinfo[0]->userid;
			$_SESSION['uname']=$uinfo[0]->username;
			$_SESSION['email']=$uinfo[0]->email;
			$_SESSION['profilepic']=$uinfo[0]->profilepic;
			$_SESSION['contact']=$uinfo[0]->contact;			
			//echo $_SESSION['picture'];
			redirect("Home");
		}
		else
		{
			$err=array(
				"msg"=>"Invalid Credentials!!"
			);
			$this->load->view("home",$err);
		}

	}

	public function logoutuser()
	{
		session_destroy();
		redirect("Home");
	}	

	public function logoutmsg()
	{
		$cinfo=$this->hm->selectallcat();
		$temp=array(
			"cat"=>$cinfo
		);
		echo "<script>";
		echo "alert('Please LogIN!')";
		echo "</script>";
		//redirect("Home");
		$this->load->view("home",$temp);
	}

	public function loginpage()
	{
		$this->load->view("login");
	}

	public function registerpage()
	{
		$this->load->view("registration");
	}

	public function loadListingPage($id)
	{
		$product_result=$this->pm->selectcompanybyuserid($id);
		
		$data=array(
			"productinfo"=>$product_result
		);
		$this->load->view("listing",$data);	
	}
	public function loadProductDisplayPage($id)
	{
		$company_row=$this->pm->companyById($id);
		$product_result=$this->pm->productByCid($id);
		//print_r($company_row);
		$data=array(
			"productinfo"=>$product_result,
			"c"=>$company_row
		);
		$this->load->view("displayproduct",$data);
	}

	public function productinfo($id)
	{
		$product_result=$this->pm1->productById($id);
		foreach ($product_result as $p) 
		{
		?>		
			<div class="row" style="margin-top: -100px; margin-left: 250px;">	
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

	public function reset_password()
	{
		$this->load->view("view_reset_password");
	}

	public function set_new_password($uname)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('txtPassword','txtPassword','required|min_length[5]');
		$this->form_validation->set_rules('txtConfirmPassword','txtConfirmPassword','required|min_length[5]');
		if($this->form_validation->run()==FALSE){
			$data=array("error"=>"Fill Properly","uname"=>$uname);
			$this->load->view("new_password",$data);
		}
		if($this->form_validation->run()==TRUE){
			$password=$this->input->post('txtPassword');
			$confirm_password=$this->input->post('txtConfirmPassword');
			$password_data=array(
				"password"=>$password
			);
			if($password===$confirm_password){
				$this->hm->set_password($password_data,$uname);
				redirect("Home");
			}
			else{

			}
		}
	}
	public function email_exist()
	{
		// validation start
		$this->load->library("form_validation");
		$this->form_validation->set_rules('txtMail','txtMail','required|valid_email');
		if ($this->form_validation->run() == FALSE)
		{
			$error_email="Invalid Email Format";
			$data=array("error"=>$error_email);
			$this->load->view("view_reset_password",$data);			
		}
		else
		{
			//check email from database
			$email=$this->input->post('txtMail');
			$email_result=$this->hm->fetchUserByEmail($email);
			if($email_result>0){
				$this->send_reset_password_email($email,$email_result['username']);	
			}
			else{
				$error_email="Email Might Be Invalid";
				$data=array("error"=>$error_email);
				$this->load->view("view_reset_password",$data);	
			}
			//check email from db end				
		}
		//validation end
	}
	public function send_reply($reply,$cid)
	{
		$comment_result=$this->hm->cmntById($cid);
		$data=array(
			"replyid"=>0,
			"commentid"=>$cid,
			"from_id"=>$_SESSION['uid'],
			"to_id"=>$comment_result['userid'],
			"commentreply"=>$reply
		);
		$this->hm->cmnt_reply($data);

		//notification record
		$ndata=array(
			"notificationid"=>0,
			"from_userid"=>$_SESSION['uid'],
			"to_userid"=>$comment_result['userid'],
			"productid"=>$comment_result['productid'],
			"comment"=>$reply,
			"cmnt_status"=>0,
			"type"=>"cr"
		);
		$this->hm->addCmntRply($ndata);
	}
	public function removeNoti($nid)
	{
		$this->hm->delNoti($nid);
		$this->load->view("userdashboard");
		//redirect(base_url('index.php/Profile/loadUserDashboard'));
	}
	public function send_reset_password_email($email,$uname)
	{
			$this->load->library('email');
			$email_code=md5($email);
			$emailContent = '<!DOCTYPE><html><head></head><body><table width="600px" style="border:1px solid #cccccc;margin: auto;border-spacing:0;"><tr><td style="background:#000000;padding-left:3%"></td></tr>';
    		$emailContent .='<tr><td style="height:20px"></td></tr>';
    		$emailContent .= '<p>Dear '.$uname.',</p>';
    		$emailContent .=  '<p>To Reset Your Password <strong><a href="'.base_url('index.php/Home/reset_password_form/'.$uname.'/'.$email_code).'">Click Here</a></strong></p>';	
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

			$this->load->library('email',$config);
			$this->email->initialize($config);
			$this->email->set_mailtype("html");
			$this->email->from('textilewarehouse1724@gmail.com');
			$this->email->to($email);
			$this->email->subject('Textile Warehouse:Reset Password');
			$this->email->message($emailContent);
			$this->email->send();
		$_SESSION['success_msg']="Email Has Been Sent!!Check It Out";
		echo $_SESSION['success_msg'];			
		


	}

	public function reset_password_form($uname,$email)
	{
		$data=array("uname"=>$uname);
		$this->load->view("new_password",$data);
	}

	public function services()
	{
		$this->load->view("services");
	}
	public function loadNotiReply($pid,$nid,$fromid,$toid,$cnt,$commentid)
	{
		$replyid=0;
		if($cnt==0){
			$data=array("cmnt_status"=>1);
			$this->hm->editcmntstatus($nid,$data);
			$product_result=$this->hm->fetchproduct($pid);
			$notification_result=$this->hm->fetchcmnt($nid);
			$pro_img_result=$this->hm->fetchPro_img($pid);
			$data=array(
				"pinfo"=>$product_result,
				"cinfo"=>$notification_result,
				"commentid"=>$commentid,
				"count"=>0,
				"piinfo"=>$pro_img_result
			);
			$this->load->view("noti_reply",$data);	
		}
		elseif($cnt==1){
			$data=array("cmnt_status"=>1);
			$this->hm->editcmntstatus($nid,$data);
			$product_result=$this->hm->fetchproduct($pid);
			$comment_result=$this->hm->cmntById($commentid);
			$notification_result=$this->hm->fetchcmnt($nid);
			$pro_img_result=$this->hm->fetchPro_img($pid);
			$data=array(
				"pinfo"=>$product_result,
				"ninfo"=>$notification_result,
				"cinfo"=>$comment_result,
				"commentid"=>$commentid,
				"count"=>$cnt,
				"piinfo"=>$pro_img_result	
			);
			$this->load->view("noti_reply",$data);	
		}
		elseif ($cnt==2) {
			$replyid=$commentid;
			$data=array("cmnt_status"=>1);
			$this->hm->editcmntstatus($nid,$data);
			$product_result=$this->hm->fetchproduct($pid);
			$reply_result=$this->hm->fetchIid($replyid);
			$inquiry_result=$this->hm->fetchInquiry($reply_result['inquiryid']);
			$pro_img_result=$this->hm->fetchPro_img($pid);
			$data=array(
				"pinfo"=>$product_result,
				"rinfo"=>$reply_result,
				"iinfo"=>$inquiry_result,
				"count"=>$cnt,
				"piinfo"=>$pro_img_result
			);
			$this->load->view("noti_reply",$data);
		}
		elseif ($cnt==3) {
			$inquiryid=$commentid;
			$data=array("cmnt_status"=>1);
			$this->hm->editcmntstatus($nid,$data);
			$pro_img_result=$this->hm->fetchPro_img($pid);
			$inquiry_result=$this->hm->fetchInquiry($inquiryid);
			$product_result=$this->hm->fetchproduct($pid);			
			$data=array(
				"pinfo"=>$product_result,
				"iinfo"=>$inquiry_result,
				"count"=>$cnt,
				"piinfo"=>$pro_img_result
			);
			$this->load->view("noti_reply",$data);
		}
	}
}

?>