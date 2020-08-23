

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("ProductM","pm");
		$this->load->model("HomeM","hm");
		$this->load->model("profileM");
	}

	public function index($id)
	{
		$_SESSION['id']=$id;
		$cat=$this->pm->selectallcat();				
		$cinfo=$this->pm->fetchCompanybycompanyid($id);
		$data=array(
			"categories"=>$cat,
			"company"=>$cinfo			
		);		
		$this->load->view("Productinsert",$data);				
	}
	
	// public function loadProductInsert($temp)
	// {
	// 	$cat=$this->pm->selectallcat();				
	// 	$cinfo=$this->pm->fetchCompanybycompanyid($id);
	// 	$data=array(
	// 		"categories"=>$cat,
	// 		"company"=>$cinfo,
	// 		"error"=>$temp			
	// 	);
	// 	$this->load->view("Productinsert",$data);
	// }
	public function loadcat()
	{
		$cinfo=$this->pm->selectallcat();		
		echo "<option value=-1>Select a sub category </option> ";
		foreach ($cinfo as $s) 
		{
		?>
			<option value="<?php echo $s->subcategoryid;?>"><?php echo $s->subcategoryname;?></option>
		<?php
		}
	}

	public function loadsubcatbycatid($cid)
	{
		$data=array(
			"categoryid"=>$cid
		);
		$_SESSION['catid']=$cid;
		$sinfo=$this->hm->selectsubcatbyid($data);		
		echo "<option value=-1>Select a sub category </option> ";
		foreach ($sinfo as $s) 
		{
		?>
			<option value="<?php echo $s->subcategoryid;?>"><?php echo $s->subcategoryname;?></option>
		<?php
		}
	}

	public function addcat()
	{
		$cname=$this->input->post("txtcat");		
		$cat=$this->pm->selectallcat();	
		$flag=0;
		foreach ($cat as $c) 
		{
			if(strcmp($c->categoryname,$cname)==0)
			{
				echo "<script>";
				echo "alert('Category already present!!')";
				echo "</script>";
				redirect(base_url('index.php/Product/index/'.$_SESSION['compid']));
				break;
			}
			else
			{
				$data=array(
					"categoryname"=>$this->input->post("txtcat")
				);
				$this->pm->insertcategory($data);
				redirect(base_url('index.php/Product/index/'.$_SESSION['compid']));
			}			
		}
		// if($flag==1)
		// {
			
		// }
		// else
		// {
		// 	echo "hello";
		// }
		// $data=array(
		// 	"categoryname"=>$this->input->post("txtcat")
		// );
		// $this->pm->insertcategory($data);
		// redirect(base_url('index.php/Product/index/'.$_SESSION['compid']));
	}

	public function addsubcat($cid)
	{
		$data2=array(
			"categoryid"=>$_SESSION['catid']
		);		

		$sinfo=$this->hm->selectsubcatbyid($data2);		
		print_r($data2);	
		$sid=$this->input->post("txtsubcat");
		echo $sid;
		foreach ($sinfo as $s) 
		{
			echo "hii";
			if(strcmp($s->subcategoryname,$sid)==0)
			{
				echo "<script>";
				echo "alert('Category already present!!')";
				echo "</script>";
				redirect(base_url('index.php/Product/index/'.$cid));				
			}
			else
			{
				$data=array(
					"subcategoryname"=>$this->input->post("txtsubcat"),
					"categoryid"=>$_SESSION['catid']
				);
				$this->pm->insertsubcategory($data);
				redirect(base_url('index.php/Product/index/'.$cid));
			}			
		}		
	}

	public function addproduct($id)
	{	
		static $pcnt=0;
		if(!empty($_FILES['fup']['name']) && (($_FILES['fup']['type']=="image/jpeg") || ($_FILES['fup']['type']=="image/jpg") || 
			($_FILES['fup']['type']=="image/png") || ($_FILES['fup']['type']=="image/JPG")))
		{
			$image=$_FILES['fup']['name'];
			copy($_FILES['fup']['tmp_name'],"C:/wamp64/www/textile/resources/user/products/".$image) or die($_FILES['fup']['error']);
		}
		else{
			$error="Invalid Product Image Format";
			$pcnt++;
		}

		$error_data=array("Err"=>$error);
		if($pcnt==0){
			$data=array(
			"productid"=>0,
			"title"=>$this->input->post("txttitle"),
			"subcategoryid"=>$this->input->post("cmbsubcat"),
			"min_price"=>$this->input->post("txtmin"),
			"max_price"=>$this->input->post("txtmax"),
			"companyid"=>$id,
			"pro_img"=>$image,
			"status"=>$this->input->post("cmbstatus"),
			"min_order"=>$this->input->post("txtorder"),
			"description"=>$this->input->post("txtinfo")
			);
			$this->pm->insertproduct($data);
			redirect(base_url('index.php/Home/loadProductDisplayPage/'.$id));
		}
		else
		{
			$this->load->view("error",$error_data);	
		}
	}

	public function test1()
	{
		$this->load->view("textarea");
	}

	public function showallproduct($id)
	{
		//echo $id;
		$_SESSION['cid']=$id;
		$pinfo=$this->pm->selectproductbycompanyid($id);
		$data=array(
			"products"=>$pinfo
		);
		//print_r($data);
		$this->load->view("displayproduct",$data);
	}

	public function loadeditproduct($id)
	{
		$cat=$this->pm->selectallcat();
		$pinfo=$this->pm->selectproductbyproductid($id);
		$data=array(
			"categories"=>$cat,
			"product"=>$pinfo			
		);
		//print_r($pinfo);
		$this->load->view("Productupdate",$data);
	}

	public function removeproduct($id)
	{		
		$company=$this->pm->fetchCompByPid($id);
		$this->pm->deleteproduct($id);
		redirect("Home/loadProductDisplayPage/".$company['companyid']);
	}

	public function editproduct($id)
	{
		$subcat="";
		$pinfo=$this->pm->selectproductbyproductid($id);
		if(!empty($_FILES['fup']['name']) && (($_FILES['fup']['type']=="image/jpeg") || ($_FILES['fup']['type']=="image/jpg") || 
			($_FILES['fup']['type']=="image/png") || ($_FILES['fup']['type']=="image/JPG")))
		{
			$image=$_FILES['fup']['name'];
			copy($_FILES['fup']['tmp_name'],"C:/wamp64/www/textile/resources/user/products/".$image) or die($_FILES['fup']['error']);
		}
		else
		{
			$image=$pinfo['pro_img'];
		}
		if($this->input->post('cmbsubcat')=="-1")
		{
			$subcat=$this->input->post('hidden');
		}
		else
		{
			$subcat=$this->input->post('cmbsubcat');
		}
		$data=array(
			"title"=>$this->input->post("txttitle"),
			"subcategoryid"=>$subcat,
			"min_price"=>$this->input->post("txtmin"),
			"max_price"=>$this->input->post("txtmax"),
			"companyid"=>$pinfo['companyid'],
			"pro_img"=>$image,
			"status"=>$this->input->post("cmbstatus"),
			"min_order"=>$this->input->post("txtorder"),
			"description"=>$this->input->post("txtinfo")
		);
		$this->pm->updateproduct($id,$data);
		redirect("Home/loadProductDisplayPage/".$pinfo['companyid']);
	}

	public function addproductimages($id)
	{
		$data=array(
			"pid"=>$id
		);
		$this->load->view("addmoreimagespage",$data);
	}

	public function addsecondaryimages($pid)
	{
		$cnt=0;
		$flag=0;
		if(empty($_FILES['fup']['name']))
		{
			$error=array(
				"msg"=>"Please select images!!",
				"pid"=>$pid
			);
			$this->load->view("addmoreimagespage",$error);
		}
		else
		{
			$pinfo=$this->pm->selectproductimagescount($pid);
			$img=$_FILES['fup']['name'];		
			$count=count($img);
			if($pinfo==5)
			{
				$error=array(
					"msg"=>"You cannot add more than 5 images",
					"pid"=>$pid
				);
				$this->load->view("addmoreimagespage",$error);
			}			
			else if($pinfo>0 && $pinfo<=5)
			{
				if(($pinfo==1 && $count<=4 ) ||  ($pinfo==2 && $count<=3) || ($pinfo==3 && $count<=2) || ($pinfo==4 && $count==1))
				{
					foreach ($_FILES['fup']['name'] as $key => $value) 
					{
						if(!empty($_FILES['fup']['name'][$key]) && (($_FILES['fup']['type'][$key]=="image/jpeg") || ($_FILES['fup']['type'][$key]=="image/jpg") || ($_FILES['fup']['type'][$key]=="image/png") || ($_FILES['fup']['type'][$key]=="image/JPG")))
						{
							$image=$_FILES['fup']['name'][$key];
							copy($_FILES['fup']['tmp_name'][$key],"C:/wamp64/www/textile/resources/user/products/".$image) or die($_FILES['fup']['error'][$key]);
							$data=array(
								"image_url"=>$image,
								"productid"=>$pid
							);	
							$this->pm->insertproductimages($data);							
						}						
						else
						{
							$error=array(
								"msg"=>"Either image type is incorrect or You have not selected any photos",
								"pid"=>$pid
							);
							$this->load->view("addmoreimagespage",$error);
						}					
					}
					redirect("Product/loadallproductimages/$pid");
				}
				else 
				{
					$cnt=5-$pinfo;
					$flag=1;
				}

				if($flag==1)
				{
					$error=array(
						"msg"=>"You can only add ".$cnt." more image",
						"pid"=>$pid
					);
					$this->load->view("addmoreimagespage",$error);
				}
			}
			else
			{
				if($count<=5)
				{
					foreach ($_FILES['fup']['name'] as $key => $value) 
					{
						if(!empty($_FILES['fup']['name'][$key]) && (($_FILES['fup']['type'][$key]=="image/jpeg") || ($_FILES['fup']['type'][$key]=="image/jpg") || ($_FILES['fup']['type'][$key]=="image/png") || ($_FILES['fup']['type'][$key]=="image/JPG")))
						{
							$image=$_FILES['fup']['name'][$key];
							copy($_FILES['fup']['tmp_name'][$key],"C:/wamp64/www
								/textile/resources/user/products/".$image) or die($_FILES['fup']['error'][$key]);
							$data=array(
							"image_url"=>$image,
							"productid"=>$pid
						);	
						$this->pm->insertproductimages($data);						
						}
						else
						{
							$error=array(
								"msg"=>"Either image type is incorrect or You have not selected any photos!",
								"pid"=>$pid
							);
							$this->load->view("addmoreimagespage",$error);
						}
					}	
					redirect("Product/loadallproductimages/$pid");			
				}
				else
				{
					$error=array(
						"msg"=>"You cannot add more than 5 images",
						"pid"=>$pid
					);
					$this->load->view("addmoreimagespage",$error);
				}
			}
		}				
	}

	public function loadallproductimages($id)
	{
		$pinfo=$this->pm->selectallproductimages($id);		
		//print_r($pinfo);
		$data=array(
			"pro_img"=>$pinfo,
			"pid"=>$id
		);
		$this->load->view("addmoreimges",$data);
	}
}

?>