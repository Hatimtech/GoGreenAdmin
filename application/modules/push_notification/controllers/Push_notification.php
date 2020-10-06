<?php
defined('BASEPATH') OR exit('No direct script access allowed');




class Push_notification extends MX_Controller {

	function __construct()
    {
		parent::__construct();
		$this->load->model('push_notification_model');
		$this->load->helper('telesign');
		$bool = $this->session->userdata('authorized');
		if($bool != 1)
		{
			//echo $bool; die;
			redirect('admin');
		}
	}
	public function index()
	{
  //  $users = $this->user_model->get_all_users();
	$users = $this->push_notification_model->get_all_users();
	// echo"<pre>";print_r($users); die;
	$data['users'] = $users;
    $data['page'] ='push_notification_view';
		//$this->template->load('template', 'user_view',$data);
		_layout($data);
	//	echo "string";
	}
	public function users()
	{
	//  $users = $this->user_model->get_all_users();
	$users = $this->push_notification_model->get_all_users();
	// echo"<pre>";print_r($users); die;
	$data['users'] = $users;
		$data['page'] ='push_notification_view';
		//$this->template->load('template', 'user_view',$data);
		_layout($data);
	//	echo "string";
	}
	public function cleaners()
	{
	//  $users = $this->user_model->get_all_users();
	$users = $this->push_notification_model->get_all_cleaners();
	// echo"<pre>";print_r($users); die;
		$data['users'] = $users;
		$data['page'] ='push_notification_cleaner_view';
		//$this->template->load('template', 'user_view',$data);
		_layout($data);
	//	echo "string";
	}

	public function send(){
		$body =$this->input->post('message');
		$title =$this->input->post('title');
		$users = $this->input->post('users');
		$for = $this->input->post('for');
		$additional = $this->input->post('additional');
		$o = $this->push_notification_model->sendPushNotification($for, $users, $title, $body,$additional);
		$data['res'] = $o;
		$data['for'] = $this->input->post('for');
	    $data['page'] ='response_view';
			//$this->template->load('template', 'user_view',$data);
			_layout($data);
	}


}
