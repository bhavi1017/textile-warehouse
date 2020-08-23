<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("profileM","pm");
		$this->load->model("HomeM","hm");
	}

	public function loadUserProfileform($uname)
	{
		$cityResult=$this->hm->fetchCityData();
		$result=$this->pm->fetchUserRegistrationData($uname);
		$data=array(
			"users"=>$result,	
			"cities"=>$cityResult
		);
		$this->load->view("useredit",$data);
	}

	public function edituser($id)
	{
		static $cnt=0;
		$uname=$this->input->post("txtName");
		if(!empty($_FILES['fup']['name']) && (($_FILES['fup']['type']=="image/jpeg") || ($_FILES['fup']['type']=="image/jpg") || ($_FILES['fup']['type']=="image/png") || ($_FILES['fup']['type']=="image/JPG")))
		{
			$image=$_FILES['fup']['name'];
			$_SESSION['profilepic']=$image;
			copy($_FILES['fup']['tmp_name'],"C:/wamp64/www/textile/resources/user/profile_pic/".$image) or die($_FILES['fup']['error']);
		}
		elseif(empty($_FILES['fup']['name']))
		{
			$image=$_SESSION['profilepic'];
		}
		else
		{
			$errorImage="**Incorrect File Type**";
			$cnt++;			
		}
		$_SESSION['uname']=$this->input->post("txtName");
		$data=array(
			"username"=>$this->input->post("txtName"),
			"email"=>$this->input->post("txtEmail"),
			"contact"=>$this->input->post("txtContact"),
			"profilepic"=>$image
		);
		$company_data=array(
			"contact"=>$this->input->post("txtContact"),
			"email"=>$this->input->post("txtEmail")
		);
		$this->pm->updateuser($data,$id);
		
		//changes into company table
		$this->pm->updateCompanyByUid($company_data,$id);

		redirect("Profile/loadprofilePage/".$_SESSION['uid']);
	}
	public function loadprofilePage($uid)
	{
		$user_result=$this->pm->fetchUser($uid);
		$data=array("uinfo"=>$user_result);
		$this->load->view("viewUserprofile.php",$data);
	}
	public function loadUserDashboard()
	{
		$id=0;
		$uname=$_SESSION['uname'];		
		$result=$this->hm->fetchUserRegisterData($uname);
		$id=$result['userid'];
		$answer=$this->pm->fetchCompaniesByUserId($id);
		$data=array(
			"users"=>$result,
			"companies"=>$answer
		);
		$this->load->view("userdashboard",$data);
		
	}
	public function loadUserProfile($uname)
	{
		$cityResult=$this->hm->fetchCityData();
		$result=$this->pm->fetchUserRegistrationData($uname);
		$data=array(
			"users"=>$result,
			"cities"=>$cityResult
		);
		$this->load->view("userprofile",$data);
	}

	public function addcompany()
	{
		static $cnt=0;
		$city=0;
		static $flag=0;
		$uid=$_SESSION['uid'];
		$uname=$cname=$image=$password=$website=$website2=$email=$contact=$contact2=$email2="";
		$errorCity=$errorImage="";
		$cityResult=$this->hm->fetchCityData();
		$uname=$this->input->post('txtName');
		$users_data=$this->pm->getCompanies();
		$ans=$this->pm->fetchUserRegistrationData($uid);
		$uid=$ans['userid'];
			if(!empty($_FILES['fup']['name']) && (($_FILES['fup']['type']=="image/jpeg") || ($_FILES['fup']['type']=="image/jpg") || ($_FILES['fup']['type']=="image/png") || ($_FILES['fup']['type']=="image/JPG")))
			{
				$image=$_FILES['fup']['name'];				
				copy($_FILES['fup']['tmp_name'],"C:/wamp64/www/textile/resources/user/company_images/".$image);
				$_SESSION['companyprofilepic']=$_FILES['fup']['name'];

			}
			elseif(empty($_FILES['fup']['name']))
			{
				$image="null";
				$_SESSION['companyprofilepic']="null";
			}
			else
			{
				$errorImage="**Incorrect File Type**";
				$cnt++;
			}

			if (empty($this->input->post('txtWebsite'))) {
				$website="NULL";
			}
			else
			{
				$website=$this->input->post('txtWebsite');
			}

			if($this->input->post('comboCity')!=-1)
			{
				$city=$this->input->post('comboCity');
			}
			else
			{
				$cnt++;
				$errorCity="*Select Please*";
			}

			if(!empty($this->input->post('txtEmail2')))
			{
				$email2=$this->input->post('txtEmail2');

			}
			$email=$this->input->post('txtEmail');

			if(!empty($this->input->post('txtContact2')))
			{
				$contact2=$this->input->post('txtContact2');

			}
			$contact=$this->input->post('txtContact');

			if(!empty($this->input->post('txtWebsite2')))
			{
				$website2=$this->input->post('txtWebsite2');

			}
			$website=$this->input->post('txtWebsite');

			if($cnt==0)
			{
				foreach ($users_data as $u) 
				{
					//echo "hi";
					if(($u['companyname']==$this->input->post('txtCompanyname')) && ($u["companyprofilepic"]==$image) && ($u['googlemapurl']==$this->input->post('txtUrl')))
					{
						$flag=1;
					}	
				}
				if($flag==1)
				{
					$data=array("report"=>1);
					$this->pm->editUser($data,$_SESSION['uid']);	
				}

				//insert code
				$data=array(
						"companyid"=>0,
						"companyname"=>$this->input->post('txtCompanyname'),
						"email"=>$email,
						"contact"=>$contact,
						"website"=>$website,
						"companyprofilepic"=>$image,
						"address"=>$this->input->post('txtAddress'),
						"bio"=>$this->input->post('txtBio'),
						"cityid"=>$city,
						"googlemapurl"=>$this->input->post('txtUrl'),
						"userid"=>$_SESSION['uid'],
				);
				$cid=$this->pm->insertcompany($data);
				//$flag=0;
				

				//insert multiple value of email
				if(!empty($email2))
				{
					$info=array(
						"companyid"=>$cid,
						"email"=>$email2
					);
					$this->pm->insertcompanyemail($info);	
				}

				//insert multiple value of contact
				if(!empty($contact2))
				{
					$cinfo=array(
						"companyid"=>$cid,
						"contact"=>$contact2
					);
					$this->pm->insertcontact($cinfo);
				}

				//insert multiple value of website
				if(!empty($website2))
				{
					$winfo=array(
						"companyid"=>$cid,
						"website"=>$website2
					);
					$this->pm->insertwebsite($winfo);	
				}
				

				redirect(base_url('index.php/Seller/seller_page/'));
			}
			else{
				$error=array(
					"errorImage"=>$errorImage,
					"errorCity"=>$errorCity,
					"cities"=>$cityResult
				);
				$this->load->view("userprofile",$error);
			}	
	}	

	public function removeUser($id)
	{
		$this->pm->deletecompany($id);
		$this->pm->deleteEmail($id);
		$this->pm->deleteContact($id);
		$this->pm->deleteWebsite($id);
		redirect(base_url('index.php/Seller/seller_page/'));
	}
	public function loadUserEditPage($id)
	{
		$answerCity=$this->hm->fetchCityData();
		$answerCompany=$this->pm->userdataById($id);
		$answerCompanyemail=$this->pm->fetchcompanyemail($id);
		$website_result=$this->pm->fetchwebsite($id);
		$contact_result=$this->pm->fetchcontact($id);
		$data=array(
			"companies"=>$answerCompany,
			"cities"=>$answerCity,
			"companyid"=>$id,
			"companyemail"=>$answerCompanyemail,
			"winfo"=>$website_result,
			"cinfo"=>$contact_result
		);
		//print_r($data);
		 $this->load->view("usereditprofile",$data);
	}
	public function editcompany($id)
	{
		static $cnt=0;
		$city=0;
		$uid=$_SESSION['uid'];
		$uname=$cname=$image=$password=$website=$email=$contact=$email2="";
		$errorCity=$errorImage="";
		$cityResult=$this->hm->fetchCityData();
		$uname=$this->input->post('txtName');
		$ans=$this->pm->fetchUserRegistrationData($uid);
		$uid=$ans['userid'];
			if(!empty($_FILES['fup']['name']) && (($_FILES['fup']['type']=="image/jpeg") || ($_FILES['fup']['type']=="image/jpg") || ($_FILES['fup']['type']=="image/png") || ($_FILES['fup']['type']=="image/JPG")))
			{
				$image=$_FILES['fup']['name'];				
				$_SESSION['companyprofilepic']=$_FILES['fup']['name'];
				copy($_FILES['fup']['tmp_name'],"C:/wamp64/www/textile/resources/user/company_images/".$image);
				echo $image;
				//print_r($_SESSION['companyprofilepic']);
			}
				elseif (empty($_FILES['fup']['name'])) 
				{				
					$image=$_SESSION['companyprofilepic'];
					echo $image;
				}
				else
				{
					$errorImage="**Incorrect File Type**";
					$cnt++;
				}

				if (empty($this->input->post('txtWebsite'))) {
					$website="null";
				}
				else
				{
					$website=$this->input->post('txtWebsite');
				}

				if(!empty($this->input->post('txtContact2')))
				{
					$contact2=$this->input->post('txtContact2');

				}
				$contact=$this->input->post('txtContact');


				if(!empty($this->input->post('txtWebsite2')))
				{
					$website2=$this->input->post('txtWebsite2');
				}
				$website=$this->input->post('txtWebsite');


				if($this->input->post('comboCity')!=-1)
				{
					$city=$this->input->post('comboCity');
				}
				else
				{
					$cnt++;
					$errorCity="*Select Please*";
				}

				if(!empty($this->input->post('txtEmail2')))
				{
					$email2=$this->input->post('txtEmail2');
				}
				$email=$this->input->post('txtEmail');

				if($cnt==0)
				{
					$data=array(
					"companyid"=>$id,
					"companyname"=>$this->input->post('txtCompanyname'),
					"email"=>$email,
					"contact"=>$contact,
					"website"=>$website,
					"companyprofilepic"=>$image,
					"address"=>$this->input->post('txtAddress'),
					"bio"=>$this->input->post('txtBio'),
					"cityid"=>$city,
					"googlemapurl"=>$this->input->post('txtUrl'),
					"userid"=>$_SESSION['uid']
					);

					$rinfo=array(
						"username"=>$this->input->post('txtName'),
						"email"=>$this->input->post('txtEmail'),
						"contact"=>$this->input->post('txtContact'),
					);
					$this->pm->updatecompany($data,$id);
					$this->pm->updateUserRegistration($rinfo,$uid);
					//update multiple value of email
					if(!empty($email2))
					{
						$info=array(
						//"companyid"=>$cid,
						"email"=>$email2
						);
						$this->pm->updatecompanyemail($info,$id);	
					}
					
					//update multiple value of contact
					if(!empty($contact2))
					{
						$cinfo=array("contact"=>$contact2);
						$this->pm->updatecontact($cinfo,$id);
					}

					//update multiple value of website
					if(!empty($website2))
					{
						$winfo=array("website"=>$websitet2);
						$this->pm->updatewebsite($winfo,$id);
					}

					redirect(base_url('index.php/Seller/seller_page/'.$uid));
				}
				else{
					$error=array(
						"errorImage"=>$errorImage,
						"errorCity"=>$errorCity,
						"cities"=>$cityResult
					);
					$this->load->view("usereditprofile",$error);
			}			
	}

	public function changepassword($uid)
	{
		$uinfo=$this->pm->fetchUserRegistrationData($uid);
		$temp=array(
			"password"=>$uinfo['password']
		);
		//print_r($uinfo);
		$this->load->view("changepassword",$temp);		
	}

	public function editpassword($uid)
	{
		$pwd=$this->input->post("txtpwd");
		$cpwd=$this->input->post("txtcpwd");

		if($pwd==$cpwd)
		{			
			$data=array(
				"password"=>$pwd
			);			
			$this->pm->updateuser($data,$uid);			
			redirect("Profile/loadprofilePage/$uid");			
		}
		else
		{			
			$m="Passwod and Confirm Password should be same";
			$err=array(
				"msg"=>$m,
				"password"=>$uinfo['password']
			);
			$this->load->view("changepassword",$err);		
		}
	}
}
?>