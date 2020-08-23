<?php

class Inquiry extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("inquiryM","im");
		$this->load->model("SearchM","sm");
		$this->load->model("ProductM","pm");
	}

	public function fetchall($cid)
	{
		$reply_result=$this->im->fetch_reply();
		$inquiry_result=$this->im->fetchAllInquiry($cid);
		$data=array(
			"inquiries"=>$inquiry_result,
			"reply"=>$reply_result,
			"cid"=>$cid,
			// "status"=>1
		);
		//print_r($inquiry_result);
		$this->load->view("inquiry",$data);		
	}
	public function see_inquiries($cid,$st)
	{
		$status=$st;
		$reply_result=$this->im->fetch_reply();
		$inquiry_result=$this->im->fetchInquiries($cid,$st);
		$data=array(
			"inquiries"=>$inquiry_result,
			"reply"=>$reply_result,
			"cid"=>$cid,
			"status"=>$st
		);
		$this->load->view("inquiry",$data);
		//print_r($inquiry_result);
	}

	public function status_inquiries($id,$status,$cid)
	{
		$reply_result=$this->im->fetch_reply();
		$i=$this->im->fetchInquiryById($id);
	?>
			<span style="margin-left: 450px;cursor:pointer;font-size:30px;margin-top: -10px;" onclick="closemodal()">&times;</span>
				<form method="post" action="<?php echo base_url('index.php/Inquiry/updateInquiry/'.$id.'/'.$status.'/'.$cid) ?>">
					<?php
					$flag=0;
						foreach($reply_result as $r)
						{
							if($r['inquiryid']==$id)
							{
								$flag=1;
								break;
							}
						}
						if($flag==1)
						{
					?>
							<h6>Reply : </h6>
							<textarea name="txtReply" id="1"><?php echo $r['reply'] ?></textarea><br><br>
					<?php		
						}
						else
						{
					?>
							<h6>Reply : </h6>
							<textarea name="txtReply"></textarea>
					<?php		
						}
					?>
					<p class="c-label">
						<?php  
							if($status==1)
							{
						?>
								<input name="cb" id="cb1" type="radio" value="1" checked><label for="cb1">SEEN</label><br>
								<input name="cb" id="t1" type="radio" value="0"><label for="t1">UNSEEN</label><br><br>
						<?php	
							}
							elseif ($status==0) 
							{
						?>
								<input name="cb" id="cb1" type="radio" value="1"><label for="cb1">SEEN</label><br><input name="cb" id="t1" type="radio" value="0" checked><label for="t1">UNSEEN</label><br><br>
						<?php
							}
							else{

							}
						?>
							
						<input type="submit" name="btnSubmit" value="SUBMIT" style="padding: 7px;background-color: #555555;color: white;box-shadow: 2px 2px 3px grey;">
					</p>
				</form>
		<?php
	}

	public function updateInquiry($id,$st,$cid)
	{
		$reply=$this->input->post('txtReply');
		$status=$this->input->post('cb');
		$reply_data=array("reply"=>$reply);
		$status_data=array("inquiry_status"=>$status);
		$reply_info=$this->im->fetchreply_byid($id);
		$inquiry_result=$this->im->fetchInquiryById($id);
		if(!empty($reply_info)){
			$this->im->edit_reply($reply_info['replyid'],$reply_data);
			$notification=array(
				"notificationid"=>0,
				"productid"=>$inquiry_result['productid'],
				"from_userid"=>$_SESSION['uid'],
				"to_userid"=>$inquiry_result['from_userid'],
				"comment"=>$reply,
				"type"=>"ir"	
			);
			$this->im->edit_status($id,$status_data);
			$this->sm->add_CNotification($notification);
			redirect(base_url('index.php/Inquiry/see_inquiries/'.$cid.'/'.$st));
		}
		else
		{
			$data=array(
				"inquiryid"=>$id,
				"reply"=>$reply,
				"from_userid"=>$inquiry_result['to_userid'],
				"to_userid"=>$inquiry_result['from_userid'],
			);
			$notification=array(
				"notificationid"=>0,
				"productid"=>$inquiry_result['productid'],
				"from_userid"=>$_SESSION['uid'],
				"to_userid"=>$inquiry_result['from_userid'],
				"comment"=>$reply,
				"type"=>"ir"	
			);
			$this->sm->add_CNotification($notification);
			$this->im->insert_reply($data);
			$this->im->edit_status($id,$status_data);
			redirect(base_url('index.php/Inquiry/see_inquiries/'.$cid.'/'.$st));
		}
	}
	public function loadInquiryPage($userid)
	{
		$company_result=$this->pm->selectcompanybyuserid($userid);
		$data=array(
			"productinfo"=>$company_result
		);
		$this->load->view("inquirypage",$data);
	}
	public function loadInquiryDisplayPage($uid)
	{
		$this->load->view("inquiry_display");
	}
}
?>