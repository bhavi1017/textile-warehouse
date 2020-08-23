<?php

class Status extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("inquiryM","im");
	}
	public function fetch_allinquiry()
	{
		$inquiry_result=$this->im->all_inquiry();
	?>
		<table>
			<tr>
				<th>Product_ID</th>
				<th>Product_Name</th>
				<th>From</th>
				<th>Message</th>
				<th>OfferPrice</th>
				<th>Reply</th>
			</tr>		
	<?php
		foreach ($inquiry_result as $inquiry) 
		{
			$reply_result=$this->im->fetchreply_byid($inquiry['inquiryid']);
	?>
			<tr>
				<td><?php echo $inquiry['productid']; ?></td>
				<td><?php echo $inquiry['title']; ?></td>
				<td><?php echo $inquiry['username']; ?></td>
				<td><?php echo $inquiry['message']; ?></td>
				<td><?php echo $inquiry['offerprice']; ?></td>
				<td>
					<form method="post" action="<?php echo base_url('index.php/Status/reply/'.$inquiry['from_userid'].'/'.$inquiry['to_userid'].'/'.$inquiry['productid'].'/'.$inquiry['inquiryid']); ?>">
					<?php
						if(!empty($reply_result))
						{
						?>
							<textarea name="txtReply"><?php echo $reply_result['reply']; ?></textarea>
						<?php	
						}
						else
						{
						?>
							<textarea name="txtReply">
								
							</textarea>
						<?php
						}
						?>
					<br>
					<button type="submit">Submit</button>
					</form>
				</td>
			</tr>		
	<?php		
		}		
	?>	
		</table>
	<?php
	}
	public function fetch_inquiry($status)
	{
		echo $status;
		$inquiry_result=$this->im->inquiryByStatus($status);
		if($status==0)
		{
	?>
			<table>
			<tr>
				<th>Product_ID</th>
				<th>Product_Name</th>
				<th>From</th>
				<th>Message</th>
				<th>OfferPrice</th>
				<th>Reply</th>
				<th>Make It Seen</th>
			</tr>
	<?php		
			foreach ($inquiry_result as $inquiry) 
			{
				$reply_result=$this->im->fetchreply_byid($inquiry['inquiryid']);
	?>
			<tr>
				<td><?php echo $inquiry['productid']; ?></td>
				<td><?php echo $inquiry['title']; ?></td>
				<td><?php echo $inquiry['username']; ?></td>
				<td><?php echo $inquiry['message']; ?></td>
				<td><?php echo $inquiry['offerprice']; ?></td>
				<td>
					<form method="post" action="<?php echo base_url('index.php/Status/reply/'.$inquiry['from_userid'].'/'.$inquiry['to_userid'].'/'.$inquiry['productid'].'/'.$inquiry['inquiryid']); ?>">
						
						<?php
						if(!empty($reply_result))
						{
						?>
							<textarea name="txtReply"><?php echo $reply_result['reply']; ?></textarea>
						<?php	
						}
						else
						{
						?>
							<textarea name="txtReply">
								
							</textarea>
						<?php
						}
						?>
						<br>
						<button type="submit">Submit</button>
					</form>
				</td>
				<td><button name="seen" id="<?php echo $inquiry['inquiryid'] ?>" style="border-radius: 10px;background-color: brown;color: white;font-weight: bold;box-shadow: 3px 3px 2px grey;" onclick="seen(this)">SEEN</button></td>
			</tr>
	<?php
			}
	?>
			</table>
	<?php		
		}
		elseif ($status==1) 
		{
	?>
			<table>
			<tr>
				<th>Product_ID</th>
				<th>Product_Name</th>
				<th>From</th>
				<th>Message</th>
				<th>OfferPrice</th>
				<th>Reply</th>
			</tr>
	<?php		
			foreach ($inquiry_result as $inquiry) 
			{
				$reply_result=$this->im->fetchreply_byid($inquiry['inquiryid']);
	?>
			<tr>
				<td><?php echo $inquiry['productid']; ?></td>
				<td><?php echo $inquiry['title']; ?></td>
				<td><?php echo $inquiry['username']; ?></td>
				<td><?php echo $inquiry['message']; ?></td>
				<td><?php echo $inquiry['offerprice']; ?></td>
				<td>
					<form method="post" action="<?php echo base_url('index.php/Status/reply/'.$inquiry['from_userid'].'/'.$inquiry['to_userid'].'/'.$inquiry['productid'].'/'.$inquiry['inquiryid']); ?>">
					<?php
						if(!empty($reply_result))
						{
						?>
							<textarea name="txtReply"><?php echo $reply_result['reply']; ?></textarea>
						<?php	
						}
						else
						{
						?>
							<textarea name="txtReply">
								
							</textarea>
						<?php
						}
						?>
					<br>
					<button type="submit">Submit</button>
					</form>
				</td>
			</tr>
	<?php
			}
	?>
			</table>

	<?php		
		}
	}
	public function makeItSeen($id)
	{
		$data=array("inquiry_status"=>1);
		$this->im->updateStatus($id,$data);	
		redirect(base_url("index.php/Inquiry/loadInquirydisplayPage/".$_SESSION['uid']));
	}
	public function reply($fid,$tid,$pid,$iid)
	{
		$reply_result=$this->im->fetchreply_byid($iid);
		$reply=$this->input->post('txtReply');
		$uname=$this->im->fetchuser($tid);
		$reply_data=array("reply"=>$reply);
		if(empty($reply_result))
		{
			$p=$this->im->fetchProduct($pid);
			$reply_data=array(
				"replyid"=>0,
				"inquiryid"=>$iid,
				"from_userid"=>$tid,
				"to_userid"=>$fid,
				"reply"=>$reply
			);
			$this->im->insert_reply($reply_data);
		}
		else
		{
			print_r($reply_data);
			$this->im->edit($iid,$reply_data);
		}
		$notification_data=array(
			"notificationid"=>0,
			"from_userid"=>$tid,
			"to_userid"=>$fid,
			"productid"=>$pid,
			"comment"=>$reply,
			"type"=>"ir"
		);
		$this->im->addnoti($notification_data);
		$emailContent = '<!DOCTYPE><html><head></head><body><table width="600px" style="border:1px solid #cccccc;margin: auto;border-spacing:0;"><tr><td style="background:#000000;padding-left:3%"></td></tr>';
    	$emailContent .='<tr><td style="height:20px"></td></tr>';
    	$emailContent .= '<p>Dear '.$uname['username'].',</p>';
    	$emailContent .=  '<p>check Out Your Inquiry Reply You Have Made For The Product By Clicking On The Link Given Below : 
    		<br>
    		<a href="'.base_url('index.php/Status/view_reply/'.$pid.'/'.$fid.'/'.$tid.'/'.$reply).'">Click Here</a>
    	 </p>';	
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
		$this->email->from('textilewarehouse1724@gmail.com');
		$this->email->to($uname['email']);
		$this->email->subject('Textile Warehouse:Inquiry Reply');
		$this->email->message($emailContent);
		$this->email->send();
		// $_SESSION['success_msg']="Email Has Been Sent!!Check It Out";
		// echo $_SESSION['success_msg'];
		redirect(base_url("index.php/Inquiry/loadInquirydisplayPage/".$_SESSION['uid']));
	}
	public function view_reply($pid,$fid,$tid,$reply)
	{
		$product_result=$this->im->fetchProduct($pid);
		$reply_result=$this->im->fetchIidByReply($fid,$tid,$reply);
		$inquiry_result=$this->im->fetchInquiry($reply_result['inquiryid']);
		print_r($product_result);
		print_r($reply_result);
		echo "hi";
		//print_r($inquiry_result);
		//$this->load->view("view_reply");	
	}
}
?>